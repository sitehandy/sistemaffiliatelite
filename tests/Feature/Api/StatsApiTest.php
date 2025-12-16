<?php

namespace Tests\Feature\Api;

use App\Models\Click;
use App\Models\Commission;
use App\Models\Conversion;
use App\Models\Program;
use App\Models\ProgramEnrollment;
use App\Models\TrackingLink;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StatsApiTest extends TestCase
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

    public function test_can_get_dashboard_stats(): void
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->getJson('/api/stats/dashboard');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'today',
                'this_month',
                'available_balance',
            ],
        ]);
    }

    public function test_can_get_performance_stats(): void
    {
        $link = TrackingLink::factory()->create([
            'user_id' => $this->affiliate->id,
            'program_id' => $this->program->id,
        ]);

        // Create some clicks and conversions
        Click::factory()->count(10)->create([
            'tracking_link_id' => $link->id,
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->getJson('/api/stats/performance');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'summary' => [
                    'total_clicks',
                    'total_conversions',
                    'conversion_rate',
                ],
            ],
        ]);
    }

    public function test_can_get_balance(): void
    {
        Commission::create([
            'user_id' => $this->affiliate->id,
            'program_id' => $this->program->id,
            'amount' => 100,
            'status' => 'approved',
        ]);

        Commission::create([
            'user_id' => $this->affiliate->id,
            'program_id' => $this->program->id,
            'amount' => 50,
            'status' => 'pending',
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->getJson('/api/payouts/balance');

        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                'available_balance' => '100.00',
                'pending_commissions' => '50.00',
            ],
        ]);
    }

    public function test_stats_are_user_specific(): void
    {
        $otherAffiliate = User::factory()->create(['role' => 'affiliate']);

        Commission::create([
            'user_id' => $otherAffiliate->id,
            'program_id' => $this->program->id,
            'amount' => 500,
            'status' => 'approved',
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->getJson('/api/payouts/balance');

        $response->assertJson([
            'data' => [
                'available_balance' => '0.00',
            ],
        ]);
    }
}
