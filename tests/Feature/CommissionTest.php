<?php

namespace Tests\Feature;

use App\Models\Commission;
use App\Models\Conversion;
use App\Models\Program;
use App\Models\ProgramEnrollment;
use App\Models\TrackingLink;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommissionTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected User $affiliate;
    protected Program $program;
    protected Commission $commission;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create(['role' => 'admin']);
        $this->affiliate = User::factory()->create(['role' => 'affiliate']);
        $this->program = Program::factory()->create();

        $enrollment = ProgramEnrollment::create([
            'user_id' => $this->affiliate->id,
            'program_id' => $this->program->id,
            'status' => 'approved',
        ]);

        $link = TrackingLink::factory()->create([
            'user_id' => $this->affiliate->id,
            'program_id' => $this->program->id,
        ]);

        $conversion = Conversion::factory()->create([
            'tracking_link_id' => $link->id,
        ]);

        $this->commission = Commission::create([
            'user_id' => $this->affiliate->id,
            'program_id' => $this->program->id,
            'conversion_id' => $conversion->id,
            'amount' => 25.00,
            'status' => 'pending',
        ]);
    }

    public function test_admin_can_view_commissions(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin/commissions');

        $response->assertStatus(200);
        $response->assertViewIs('admin.commissions.index');
    }

    public function test_admin_can_approve_commission(): void
    {
        $response = $this->actingAs($this->admin)
            ->post("/admin/commissions/{$this->commission->id}/approve");

        $response->assertRedirect();
        $this->assertDatabaseHas('commissions', [
            'id' => $this->commission->id,
            'status' => 'approved',
        ]);
    }

    public function test_admin_can_reject_commission(): void
    {
        $response = $this->actingAs($this->admin)
            ->post("/admin/commissions/{$this->commission->id}/reject", [
                'rejection_reason' => 'Fraudulent activity',
            ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('commissions', [
            'id' => $this->commission->id,
            'status' => 'rejected',
        ]);
    }

    public function test_admin_can_bulk_approve_commissions(): void
    {
        $commission2 = Commission::create([
            'user_id' => $this->affiliate->id,
            'program_id' => $this->program->id,
            'amount' => 30.00,
            'status' => 'pending',
        ]);

        $response = $this->actingAs($this->admin)
            ->post('/admin/commissions/bulk-approve', [
                'commission_ids' => [$this->commission->id, $commission2->id],
            ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('commissions', ['id' => $this->commission->id, 'status' => 'approved']);
        $this->assertDatabaseHas('commissions', ['id' => $commission2->id, 'status' => 'approved']);
    }

    public function test_affiliate_can_view_own_commissions(): void
    {
        $response = $this->actingAs($this->affiliate)->get('/affiliate/commissions');

        $response->assertStatus(200);
        $response->assertViewIs('affiliate.commissions.index');
    }

    public function test_affiliate_cannot_view_others_commissions(): void
    {
        $otherAffiliate = User::factory()->create(['role' => 'affiliate']);

        $response = $this->actingAs($otherAffiliate)->get('/affiliate/commissions');

        $response->assertStatus(200);
        $response->assertDontSee('$25.00');
    }

    public function test_commission_cannot_be_approved_twice(): void
    {
        $this->commission->update(['status' => 'approved']);

        $response = $this->actingAs($this->admin)
            ->post("/admin/commissions/{$this->commission->id}/approve");

        $response->assertRedirect();
        $response->assertSessionHas('error');
    }
}
