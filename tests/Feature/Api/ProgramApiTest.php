<?php

namespace Tests\Feature\Api;

use App\Models\Program;
use App\Models\ProgramEnrollment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProgramApiTest extends TestCase
{
    use RefreshDatabase;

    protected User $affiliate;
    protected string $token;

    protected function setUp(): void
    {
        parent::setUp();

        $this->affiliate = User::factory()->create(['role' => 'affiliate']);
        $this->token = $this->affiliate->createToken('test-token')->plainTextToken;
    }

    public function test_can_list_programs(): void
    {
        Program::factory()->count(5)->create(['is_active' => true]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->getJson('/api/programs');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => ['id', 'name', 'slug', 'commission_type', 'commission_value'],
            ],
        ]);
    }

    public function test_can_view_single_program(): void
    {
        $program = Program::factory()->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->getJson("/api/programs/{$program->id}");

        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                'id' => $program->id,
                'name' => $program->name,
            ],
        ]);
    }

    public function test_can_enroll_in_program(): void
    {
        $program = Program::factory()->create([
            'is_active' => true,
            'requires_approval' => true,
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->postJson("/api/programs/{$program->id}/enroll");

        $response->assertStatus(201);
        $this->assertDatabaseHas('program_enrollments', [
            'user_id' => $this->affiliate->id,
            'program_id' => $program->id,
        ]);
    }

    public function test_cannot_enroll_in_inactive_program(): void
    {
        $program = Program::factory()->create(['is_active' => false]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->postJson("/api/programs/{$program->id}/enroll");

        $response->assertStatus(422);
    }

    public function test_can_list_enrolled_programs(): void
    {
        $program = Program::factory()->create();
        ProgramEnrollment::create([
            'user_id' => $this->affiliate->id,
            'program_id' => $program->id,
            'status' => 'approved',
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->getJson('/api/enrollments');

        $response->assertStatus(200);
        $response->assertJsonCount(1, 'data');
    }
}
