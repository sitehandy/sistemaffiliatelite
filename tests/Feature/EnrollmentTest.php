<?php

namespace Tests\Feature;

use App\Models\Program;
use App\Models\ProgramEnrollment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EnrollmentTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected User $affiliate;
    protected Program $program;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create(['role' => 'admin']);
        $this->affiliate = User::factory()->create(['role' => 'affiliate']);
        $this->program = Program::factory()->create([
            'is_active' => true,
            'requires_approval' => true,
        ]);
    }

    public function test_affiliate_can_enroll_in_program(): void
    {
        $response = $this->actingAs($this->affiliate)
            ->post("/affiliate/programs/{$this->program->id}/enroll");

        $response->assertRedirect();
        $this->assertDatabaseHas('program_enrollments', [
            'user_id' => $this->affiliate->id,
            'program_id' => $this->program->id,
            'status' => 'pending',
        ]);
    }

    public function test_affiliate_cannot_enroll_twice(): void
    {
        ProgramEnrollment::create([
            'user_id' => $this->affiliate->id,
            'program_id' => $this->program->id,
            'status' => 'pending',
        ]);

        $response = $this->actingAs($this->affiliate)
            ->post("/affiliate/programs/{$this->program->id}/enroll");

        $response->assertRedirect();
        $response->assertSessionHas('error');
    }

    public function test_auto_approve_enrollment_when_not_required(): void
    {
        $program = Program::factory()->create([
            'is_active' => true,
            'requires_approval' => false,
        ]);

        $response = $this->actingAs($this->affiliate)
            ->post("/affiliate/programs/{$program->id}/enroll");

        $this->assertDatabaseHas('program_enrollments', [
            'user_id' => $this->affiliate->id,
            'program_id' => $program->id,
            'status' => 'approved',
        ]);
    }

    public function test_admin_can_view_pending_enrollments(): void
    {
        ProgramEnrollment::factory()->count(5)->create(['status' => 'pending']);

        $response = $this->actingAs($this->admin)->get('/admin/enrollments');

        $response->assertStatus(200);
        $response->assertViewIs('admin.enrollments.index');
    }

    public function test_admin_can_approve_enrollment(): void
    {
        $enrollment = ProgramEnrollment::create([
            'user_id' => $this->affiliate->id,
            'program_id' => $this->program->id,
            'status' => 'pending',
        ]);

        $response = $this->actingAs($this->admin)
            ->post("/admin/enrollments/{$enrollment->id}/approve");

        $response->assertRedirect();
        $this->assertDatabaseHas('program_enrollments', [
            'id' => $enrollment->id,
            'status' => 'approved',
        ]);
    }

    public function test_admin_can_reject_enrollment(): void
    {
        $enrollment = ProgramEnrollment::create([
            'user_id' => $this->affiliate->id,
            'program_id' => $this->program->id,
            'status' => 'pending',
        ]);

        $response = $this->actingAs($this->admin)
            ->post("/admin/enrollments/{$enrollment->id}/reject", [
                'rejection_reason' => 'Not qualified',
            ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('program_enrollments', [
            'id' => $enrollment->id,
            'status' => 'rejected',
        ]);
    }

    public function test_affiliate_can_view_enrolled_programs(): void
    {
        ProgramEnrollment::create([
            'user_id' => $this->affiliate->id,
            'program_id' => $this->program->id,
            'status' => 'approved',
        ]);

        $response = $this->actingAs($this->affiliate)->get('/affiliate/programs/enrolled');

        $response->assertStatus(200);
        $response->assertViewIs('affiliate.programs.enrolled');
    }
}
