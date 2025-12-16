<?php

namespace Tests\Feature;

use App\Models\Program;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProgramTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected User $affiliate;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create(['role' => 'admin']);
        $this->affiliate = User::factory()->create(['role' => 'affiliate']);
    }

    public function test_admin_can_view_programs_list(): void
    {
        Program::factory()->count(5)->create();

        $response = $this->actingAs($this->admin)->get('/admin/programs');

        $response->assertStatus(200);
        $response->assertViewIs('admin.programs.index');
    }

    public function test_admin_can_create_program(): void
    {
        $response = $this->actingAs($this->admin)->post('/admin/programs', [
            'name' => 'Test Program',
            'slug' => 'test-program',
            'description' => 'Test description',
            'commission_type' => 'percentage',
            'commission_value' => 15,
            'cookie_duration' => 30,
            'min_payout' => 50,
            'is_active' => true,
            'requires_approval' => true,
        ]);

        $response->assertRedirect('/admin/programs');
        $this->assertDatabaseHas('programs', [
            'name' => 'Test Program',
            'slug' => 'test-program',
        ]);
    }

    public function test_admin_can_update_program(): void
    {
        $program = Program::factory()->create();

        $response = $this->actingAs($this->admin)->put("/admin/programs/{$program->id}", [
            'name' => 'Updated Program',
            'slug' => $program->slug,
            'commission_type' => 'fixed',
            'commission_value' => 10,
            'cookie_duration' => 60,
            'min_payout' => 100,
        ]);

        $response->assertRedirect('/admin/programs');
        $this->assertDatabaseHas('programs', [
            'id' => $program->id,
            'name' => 'Updated Program',
            'commission_type' => 'fixed',
        ]);
    }

    public function test_admin_can_delete_program(): void
    {
        $program = Program::factory()->create();

        $response = $this->actingAs($this->admin)->delete("/admin/programs/{$program->id}");

        $response->assertRedirect('/admin/programs');
        $this->assertDatabaseMissing('programs', ['id' => $program->id]);
    }

    public function test_affiliate_cannot_create_program(): void
    {
        $response = $this->actingAs($this->affiliate)->post('/admin/programs', [
            'name' => 'Test Program',
            'slug' => 'test-program',
            'commission_type' => 'percentage',
            'commission_value' => 15,
            'cookie_duration' => 30,
            'min_payout' => 50,
        ]);

        $response->assertStatus(403);
    }

    public function test_affiliate_can_view_available_programs(): void
    {
        Program::factory()->count(3)->create(['is_active' => true]);
        Program::factory()->count(2)->create(['is_active' => false]);

        $response = $this->actingAs($this->affiliate)->get('/affiliate/programs');

        $response->assertStatus(200);
        $response->assertViewIs('affiliate.programs.index');
    }

    public function test_program_requires_unique_slug(): void
    {
        Program::factory()->create(['slug' => 'test-slug']);

        $response = $this->actingAs($this->admin)->post('/admin/programs', [
            'name' => 'New Program',
            'slug' => 'test-slug',
            'commission_type' => 'percentage',
            'commission_value' => 15,
            'cookie_duration' => 30,
            'min_payout' => 50,
        ]);

        $response->assertSessionHasErrors('slug');
    }
}
