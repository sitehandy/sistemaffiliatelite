<?php

namespace Tests\Feature;

use App\Models\Click;
use App\Models\Commission;
use App\Models\Conversion;
use App\Models\Program;
use App\Models\ProgramEnrollment;
use App\Models\TrackingLink;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ConversionTest extends TestCase
{
    use RefreshDatabase;

    protected User $affiliate;
    protected Program $program;
    protected TrackingLink $link;

    protected function setUp(): void
    {
        parent::setUp();

        $this->affiliate = User::factory()->create(['role' => 'affiliate']);
        $this->program = Program::factory()->create([
            'is_active' => true,
            'commission_type' => 'percentage',
            'commission_value' => 10,
        ]);

        ProgramEnrollment::create([
            'user_id' => $this->affiliate->id,
            'program_id' => $this->program->id,
            'status' => 'approved',
        ]);

        $this->link = TrackingLink::factory()->create([
            'user_id' => $this->affiliate->id,
            'program_id' => $this->program->id,
        ]);
    }

    public function test_tracking_link_redirects_correctly(): void
    {
        $response = $this->get("/track/{$this->link->code}");

        $response->assertRedirect();
    }

    public function test_click_is_recorded(): void
    {
        $this->get("/track/{$this->link->code}");

        $this->assertDatabaseHas('clicks', [
            'tracking_link_id' => $this->link->id,
        ]);
    }

    public function test_conversion_can_be_recorded_via_api(): void
    {
        $response = $this->postJson('/api/conversions', [
            'tracking_code' => $this->link->code,
            'order_id' => 'ORD-12345',
            'amount' => 100.00,
            'customer_email' => 'customer@example.com',
        ], [
            'X-API-Key' => config('app.api_key', 'test-key'),
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('conversions', [
            'tracking_link_id' => $this->link->id,
            'order_id' => 'ORD-12345',
            'amount' => 100.00,
        ]);
    }

    public function test_commission_is_created_for_conversion(): void
    {
        $this->postJson('/api/conversions', [
            'tracking_code' => $this->link->code,
            'order_id' => 'ORD-12345',
            'amount' => 100.00,
        ], [
            'X-API-Key' => config('app.api_key', 'test-key'),
        ]);

        $this->assertDatabaseHas('commissions', [
            'user_id' => $this->affiliate->id,
            'program_id' => $this->program->id,
            'amount' => 10.00, // 10% of 100
        ]);
    }

    public function test_fixed_commission_calculation(): void
    {
        $program = Program::factory()->create([
            'is_active' => true,
            'commission_type' => 'fixed',
            'commission_value' => 25,
        ]);

        ProgramEnrollment::create([
            'user_id' => $this->affiliate->id,
            'program_id' => $program->id,
            'status' => 'approved',
        ]);

        $link = TrackingLink::factory()->create([
            'user_id' => $this->affiliate->id,
            'program_id' => $program->id,
        ]);

        $this->postJson('/api/conversions', [
            'tracking_code' => $link->code,
            'order_id' => 'ORD-12346',
            'amount' => 500.00,
        ], [
            'X-API-Key' => config('app.api_key', 'test-key'),
        ]);

        $this->assertDatabaseHas('commissions', [
            'user_id' => $this->affiliate->id,
            'program_id' => $program->id,
            'amount' => 25.00, // Fixed commission
        ]);
    }

    public function test_duplicate_order_id_is_rejected(): void
    {
        Conversion::factory()->create([
            'tracking_link_id' => $this->link->id,
            'order_id' => 'ORD-12345',
        ]);

        $response = $this->postJson('/api/conversions', [
            'tracking_code' => $this->link->code,
            'order_id' => 'ORD-12345',
            'amount' => 100.00,
        ], [
            'X-API-Key' => config('app.api_key', 'test-key'),
        ]);

        $response->assertStatus(422);
    }

    public function test_invalid_tracking_code_is_rejected(): void
    {
        $response = $this->postJson('/api/conversions', [
            'tracking_code' => 'invalid-code',
            'order_id' => 'ORD-12345',
            'amount' => 100.00,
        ], [
            'X-API-Key' => config('app.api_key', 'test-key'),
        ]);

        $response->assertStatus(422);
    }
}
