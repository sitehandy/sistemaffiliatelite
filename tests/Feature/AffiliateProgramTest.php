<?php

use App\Models\AffiliateProgram;
use App\Models\Product;
use App\Models\Role;
use App\Models\User;

beforeEach(function () {
    $adminRole = Role::create(['name' => 'admin', 'permissions' => ['*']]);
    $affiliateRole = Role::create(['name' => 'affiliate', 'permissions' => ['programs.view', 'enrollments.apply']]);

    $this->admin = User::factory()->create(['role_id' => $adminRole->id]);
    $this->affiliate = User::factory()->create(['role_id' => $affiliateRole->id]);
});

describe('Admin Program Management', function () {
    test('admin can create affiliate program', function () {
        $token = $this->admin->createToken('test')->plainTextToken;

        $response = $this->withToken($token)
            ->postJson('/api/admin/programs', [
                'name' => 'Test Program',
                'description' => 'A test affiliate program',
                'program_type' => 'sale',
                'commission_type' => 'percentage',
                'commission_amount' => 10,
                'visibility' => 'open',
                'is_active' => true,
            ]);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'message',
                'program' => ['id', 'name', 'program_type', 'commission_type', 'commission_amount'],
            ]);
    });

    test('admin can update affiliate program', function () {
        $program = AffiliateProgram::factory()->create();
        $token = $this->admin->createToken('test')->plainTextToken;

        $response = $this->withToken($token)
            ->putJson("/api/admin/programs/{$program->id}", [
                'name' => 'Updated Program Name',
                'commission_amount' => 15,
            ]);

        $response->assertOk();
        expect($program->fresh()->name)->toBe('Updated Program Name');
        expect((float) $program->fresh()->commission_amount)->toBe(15.0);
    });

    test('admin can delete affiliate program without enrollments', function () {
        $program = AffiliateProgram::factory()->create();
        $token = $this->admin->createToken('test')->plainTextToken;

        $response = $this->withToken($token)
            ->deleteJson("/api/admin/programs/{$program->id}");

        $response->assertOk();
        expect(AffiliateProgram::find($program->id))->toBeNull();
    });

    test('admin can toggle program status', function () {
        $program = AffiliateProgram::factory()->create(['is_active' => true]);
        $token = $this->admin->createToken('test')->plainTextToken;

        $response = $this->withToken($token)
            ->postJson("/api/admin/programs/{$program->id}/toggle-status");

        $response->assertOk();
        expect($program->fresh()->is_active)->toBeFalse();
    });
});

describe('Affiliate Program Access', function () {
    test('affiliate can view active programs', function () {
        AffiliateProgram::factory()->count(3)->create(['is_active' => true]);
        AffiliateProgram::factory()->create(['is_active' => false]);

        $token = $this->affiliate->createToken('test')->plainTextToken;

        $response = $this->withToken($token)
            ->getJson('/api/affiliate/programs');

        $response->assertOk()
            ->assertJsonCount(3, 'data');
    });

    test('affiliate can enroll in a program', function () {
        $program = AffiliateProgram::factory()->create(['is_active' => true]);
        $token = $this->affiliate->createToken('test')->plainTextToken;

        $response = $this->withToken($token)
            ->postJson("/api/affiliate/programs/{$program->id}/enroll");

        $response->assertStatus(201)
            ->assertJson(['message' => 'Enrollment request submitted successfully.']);
    });

    test('affiliate cannot enroll in inactive program', function () {
        $program = AffiliateProgram::factory()->create(['is_active' => false]);
        $token = $this->affiliate->createToken('test')->plainTextToken;

        $response = $this->withToken($token)
            ->postJson("/api/affiliate/programs/{$program->id}/enroll");

        $response->assertStatus(422);
    });

    test('affiliate cannot enroll twice in same program', function () {
        $program = AffiliateProgram::factory()->create(['is_active' => true]);
        $token = $this->affiliate->createToken('test')->plainTextToken;

        // First enrollment
        $this->withToken($token)
            ->postJson("/api/affiliate/programs/{$program->id}/enroll");

        // Second enrollment attempt
        $response = $this->withToken($token)
            ->postJson("/api/affiliate/programs/{$program->id}/enroll");

        $response->assertStatus(422)
            ->assertJson(['message' => 'You are already enrolled in this program.']);
    });
});

describe('Commission Calculation', function () {
    test('percentage commission calculates correctly', function () {
        $program = AffiliateProgram::factory()->create([
            'commission_type' => 'percentage',
            'commission_amount' => 10,
        ]);

        expect($program->calculateCommission(100))->toBe(10.0);
        expect($program->calculateCommission(250))->toBe(25.0);
    });

    test('flat rate commission calculates correctly', function () {
        $program = AffiliateProgram::factory()->create([
            'commission_type' => 'flat',
            'commission_amount' => 5,
        ]);

        expect($program->calculateCommission(100))->toBe(5.0);
        expect($program->calculateCommission(500))->toBe(5.0);
    });
});
