<?php

namespace Tests\Feature;

use App\Models\PaymentMethod;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PaymentMethodTest extends TestCase
{
    use RefreshDatabase;

    protected User $affiliate;

    protected function setUp(): void
    {
        parent::setUp();

        $this->affiliate = User::factory()->create(['role' => 'affiliate']);
    }

    public function test_affiliate_can_view_payment_methods(): void
    {
        PaymentMethod::create([
            'user_id' => $this->affiliate->id,
            'type' => 'paypal',
            'details' => ['email' => 'test@example.com'],
            'is_active' => true,
        ]);

        $response = $this->actingAs($this->affiliate)->get('/affiliate/payment-methods');

        $response->assertStatus(200);
        $response->assertViewIs('affiliate.payouts.payment-methods');
    }

    public function test_affiliate_can_add_paypal_payment_method(): void
    {
        $response = $this->actingAs($this->affiliate)->post('/affiliate/payment-methods', [
            'type' => 'paypal',
            'details' => [
                'email' => 'paypal@example.com',
            ],
            'is_primary' => true,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('payment_methods', [
            'user_id' => $this->affiliate->id,
            'type' => 'paypal',
            'is_primary' => true,
        ]);
    }

    public function test_affiliate_can_add_bank_transfer_payment_method(): void
    {
        $response = $this->actingAs($this->affiliate)->post('/affiliate/payment-methods', [
            'type' => 'bank_transfer',
            'details' => [
                'bank_name' => 'Test Bank',
                'account_name' => 'John Doe',
                'account_number' => '123456789',
                'routing_number' => '021000021',
            ],
            'is_primary' => false,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('payment_methods', [
            'user_id' => $this->affiliate->id,
            'type' => 'bank_transfer',
        ]);
    }

    public function test_only_one_primary_payment_method(): void
    {
        PaymentMethod::create([
            'user_id' => $this->affiliate->id,
            'type' => 'paypal',
            'details' => ['email' => 'old@example.com'],
            'is_primary' => true,
            'is_active' => true,
        ]);

        $this->actingAs($this->affiliate)->post('/affiliate/payment-methods', [
            'type' => 'paypal',
            'details' => ['email' => 'new@example.com'],
            'is_primary' => true,
        ]);

        $this->assertDatabaseHas('payment_methods', [
            'user_id' => $this->affiliate->id,
            'details->email' => 'old@example.com',
            'is_primary' => false,
        ]);

        $this->assertDatabaseHas('payment_methods', [
            'user_id' => $this->affiliate->id,
            'details->email' => 'new@example.com',
            'is_primary' => true,
        ]);
    }

    public function test_affiliate_can_delete_payment_method(): void
    {
        $paymentMethod = PaymentMethod::create([
            'user_id' => $this->affiliate->id,
            'type' => 'paypal',
            'details' => ['email' => 'test@example.com'],
            'is_active' => true,
        ]);

        $response = $this->actingAs($this->affiliate)
            ->delete("/affiliate/payment-methods/{$paymentMethod->id}");

        $response->assertRedirect();
        $this->assertDatabaseMissing('payment_methods', ['id' => $paymentMethod->id]);
    }

    public function test_affiliate_cannot_delete_others_payment_method(): void
    {
        $otherAffiliate = User::factory()->create(['role' => 'affiliate']);
        $paymentMethod = PaymentMethod::create([
            'user_id' => $otherAffiliate->id,
            'type' => 'paypal',
            'details' => ['email' => 'other@example.com'],
            'is_active' => true,
        ]);

        $response = $this->actingAs($this->affiliate)
            ->delete("/affiliate/payment-methods/{$paymentMethod->id}");

        $response->assertStatus(403);
    }
}
