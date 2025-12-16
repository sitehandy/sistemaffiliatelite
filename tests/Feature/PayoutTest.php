<?php

namespace Tests\Feature;

use App\Models\Commission;
use App\Models\PaymentMethod;
use App\Models\Payout;
use App\Models\Program;
use App\Models\ProgramEnrollment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PayoutTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected User $affiliate;
    protected PaymentMethod $paymentMethod;
    protected Program $program;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create(['role' => 'admin']);
        $this->affiliate = User::factory()->create(['role' => 'affiliate']);

        $this->paymentMethod = PaymentMethod::create([
            'user_id' => $this->affiliate->id,
            'type' => 'paypal',
            'details' => ['email' => 'affiliate@example.com'],
            'is_primary' => true,
            'is_active' => true,
        ]);

        $this->program = Program::factory()->create(['min_payout' => 50]);

        ProgramEnrollment::create([
            'user_id' => $this->affiliate->id,
            'program_id' => $this->program->id,
            'status' => 'approved',
        ]);

        // Create approved commissions
        Commission::create([
            'user_id' => $this->affiliate->id,
            'program_id' => $this->program->id,
            'amount' => 100.00,
            'status' => 'approved',
        ]);
    }

    public function test_affiliate_can_view_payouts(): void
    {
        $response = $this->actingAs($this->affiliate)->get('/affiliate/payouts');

        $response->assertStatus(200);
        $response->assertViewIs('affiliate.payouts.index');
    }

    public function test_affiliate_can_request_payout(): void
    {
        $response = $this->actingAs($this->affiliate)->post('/affiliate/payouts', [
            'payment_method_id' => $this->paymentMethod->id,
        ]);

        $response->assertRedirect('/affiliate/payouts');
        $this->assertDatabaseHas('payouts', [
            'user_id' => $this->affiliate->id,
            'payment_method_id' => $this->paymentMethod->id,
            'status' => 'pending',
        ]);
    }

    public function test_affiliate_cannot_request_payout_below_minimum(): void
    {
        // Update commission to be below minimum
        Commission::where('user_id', $this->affiliate->id)->update(['amount' => 10]);

        $response = $this->actingAs($this->affiliate)->post('/affiliate/payouts', [
            'payment_method_id' => $this->paymentMethod->id,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('error');
    }

    public function test_affiliate_cannot_request_payout_without_payment_method(): void
    {
        $this->paymentMethod->delete();

        $response = $this->actingAs($this->affiliate)->post('/affiliate/payouts', [
            'payment_method_id' => 999,
        ]);

        $response->assertSessionHasErrors('payment_method_id');
    }

    public function test_admin_can_view_payout_requests(): void
    {
        Payout::create([
            'user_id' => $this->affiliate->id,
            'payment_method_id' => $this->paymentMethod->id,
            'amount' => 100,
            'fee' => 0,
            'total_amount' => 100,
            'status' => 'pending',
        ]);

        $response = $this->actingAs($this->admin)->get('/admin/payouts');

        $response->assertStatus(200);
        $response->assertViewIs('admin.payouts.index');
    }

    public function test_admin_can_approve_payout(): void
    {
        $payout = Payout::create([
            'user_id' => $this->affiliate->id,
            'payment_method_id' => $this->paymentMethod->id,
            'amount' => 100,
            'fee' => 0,
            'total_amount' => 100,
            'status' => 'pending',
        ]);

        $response = $this->actingAs($this->admin)
            ->post("/admin/payouts/{$payout->id}/approve");

        $response->assertRedirect();
        $this->assertDatabaseHas('payouts', [
            'id' => $payout->id,
            'status' => 'approved',
        ]);
    }

    public function test_admin_can_mark_payout_completed(): void
    {
        $payout = Payout::create([
            'user_id' => $this->affiliate->id,
            'payment_method_id' => $this->paymentMethod->id,
            'amount' => 100,
            'fee' => 0,
            'total_amount' => 100,
            'status' => 'approved',
        ]);

        $response = $this->actingAs($this->admin)
            ->post("/admin/payouts/{$payout->id}/complete", [
                'transaction_id' => 'TXN-123456',
            ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('payouts', [
            'id' => $payout->id,
            'status' => 'completed',
            'transaction_id' => 'TXN-123456',
        ]);
    }

    public function test_commissions_are_marked_paid_after_payout(): void
    {
        $commission = Commission::where('user_id', $this->affiliate->id)->first();

        $payout = Payout::create([
            'user_id' => $this->affiliate->id,
            'payment_method_id' => $this->paymentMethod->id,
            'amount' => 100,
            'fee' => 0,
            'total_amount' => 100,
            'status' => 'approved',
        ]);

        // Attach commission to payout
        $payout->commissions()->attach($commission->id);

        $this->actingAs($this->admin)
            ->post("/admin/payouts/{$payout->id}/complete", [
                'transaction_id' => 'TXN-123456',
            ]);

        $this->assertDatabaseHas('commissions', [
            'id' => $commission->id,
            'status' => 'paid',
        ]);
    }
}
