<?php

namespace Tests\Feature;

use App\Models\Program;
use App\Models\ProgramEnrollment;
use App\Models\TrackingLink;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TrackingLinkTest extends TestCase
{
    use RefreshDatabase;

    protected User $affiliate;
    protected Program $program;
    protected ProgramEnrollment $enrollment;

    protected function setUp(): void
    {
        parent::setUp();

        $this->affiliate = User::factory()->create(['role' => 'affiliate']);
        $this->program = Program::factory()->create(['is_active' => true]);
        $this->enrollment = ProgramEnrollment::create([
            'user_id' => $this->affiliate->id,
            'program_id' => $this->program->id,
            'status' => 'approved',
        ]);
    }

    public function test_affiliate_can_view_links(): void
    {
        TrackingLink::factory()->count(3)->create([
            'user_id' => $this->affiliate->id,
            'program_id' => $this->program->id,
        ]);

        $response = $this->actingAs($this->affiliate)->get('/affiliate/links');

        $response->assertStatus(200);
        $response->assertViewIs('affiliate.links.index');
    }

    public function test_affiliate_can_create_link(): void
    {
        $response = $this->actingAs($this->affiliate)->post('/affiliate/links', [
            'program_id' => $this->program->id,
            'name' => 'Test Link',
            'campaign' => 'test-campaign',
        ]);

        $response->assertRedirect('/affiliate/links');
        $this->assertDatabaseHas('tracking_links', [
            'user_id' => $this->affiliate->id,
            'program_id' => $this->program->id,
            'name' => 'Test Link',
            'campaign' => 'test-campaign',
        ]);
    }

    public function test_link_code_is_generated_automatically(): void
    {
        $this->actingAs($this->affiliate)->post('/affiliate/links', [
            'program_id' => $this->program->id,
            'name' => 'Test Link',
        ]);

        $link = TrackingLink::first();
        $this->assertNotNull($link->code);
        $this->assertEquals(10, strlen($link->code));
    }

    public function test_affiliate_cannot_create_link_for_unenrolled_program(): void
    {
        $otherProgram = Program::factory()->create();

        $response = $this->actingAs($this->affiliate)->post('/affiliate/links', [
            'program_id' => $otherProgram->id,
            'name' => 'Test Link',
        ]);

        $response->assertSessionHasErrors('program_id');
    }

    public function test_affiliate_can_delete_link(): void
    {
        $link = TrackingLink::factory()->create([
            'user_id' => $this->affiliate->id,
            'program_id' => $this->program->id,
        ]);

        $response = $this->actingAs($this->affiliate)
            ->delete("/affiliate/links/{$link->id}");

        $response->assertRedirect('/affiliate/links');
        $this->assertDatabaseMissing('tracking_links', ['id' => $link->id]);
    }

    public function test_affiliate_cannot_delete_others_link(): void
    {
        $otherAffiliate = User::factory()->create(['role' => 'affiliate']);
        $link = TrackingLink::factory()->create([
            'user_id' => $otherAffiliate->id,
            'program_id' => $this->program->id,
        ]);

        $response = $this->actingAs($this->affiliate)
            ->delete("/affiliate/links/{$link->id}");

        $response->assertStatus(403);
    }
}
