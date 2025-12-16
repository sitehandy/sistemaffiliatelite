<?php

namespace Tests\Feature\Api;

use App\Models\Program;
use App\Models\ProgramEnrollment;
use App\Models\TrackingLink;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LinkApiTest extends TestCase
{
    use RefreshDatabase;

    protected User $affiliate;
    protected string $token;
    protected Program $program;

    protected function setUp(): void
    {
        parent::setUp();

        $this->affiliate = User::factory()->create(['role' => 'affiliate']);
        $this->token = $this->affiliate->createToken('test-token')->plainTextToken;
        $this->program = Program::factory()->create(['is_active' => true]);

        ProgramEnrollment::create([
            'user_id' => $this->affiliate->id,
            'program_id' => $this->program->id,
            'status' => 'approved',
        ]);
    }

    public function test_can_list_links(): void
    {
        TrackingLink::factory()->count(3)->create([
            'user_id' => $this->affiliate->id,
            'program_id' => $this->program->id,
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->getJson('/api/links');

        $response->assertStatus(200);
        $response->assertJsonCount(3, 'data');
    }

    public function test_can_create_link(): void
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->postJson('/api/links', [
            'program_id' => $this->program->id,
            'name' => 'Test Link',
            'campaign' => 'test-campaign',
        ]);

        $response->assertStatus(201);
        $response->assertJsonStructure([
            'data' => ['id', 'name', 'code', 'url'],
        ]);
    }

    public function test_can_get_link_stats(): void
    {
        $link = TrackingLink::factory()->create([
            'user_id' => $this->affiliate->id,
            'program_id' => $this->program->id,
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->getJson("/api/links/{$link->id}/stats");

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => ['link_id', 'clicks', 'conversions'],
        ]);
    }

    public function test_can_delete_link(): void
    {
        $link = TrackingLink::factory()->create([
            'user_id' => $this->affiliate->id,
            'program_id' => $this->program->id,
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->deleteJson("/api/links/{$link->id}");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('tracking_links', ['id' => $link->id]);
    }

    public function test_cannot_access_others_links(): void
    {
        $otherAffiliate = User::factory()->create(['role' => 'affiliate']);
        $link = TrackingLink::factory()->create([
            'user_id' => $otherAffiliate->id,
            'program_id' => $this->program->id,
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->deleteJson("/api/links/{$link->id}");

        $response->assertStatus(403);
    }
}
