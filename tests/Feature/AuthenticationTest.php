<?php

use App\Models\Role;
use App\Models\User;

beforeEach(function () {
    Role::create(['name' => 'affiliate', 'permissions' => ['programs.view']]);
    Role::create(['name' => 'admin', 'permissions' => ['*']]);
});

describe('Registration', function () {
    test('new users can register via API', function () {
        $response = $this->postJson('/api/auth/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'message',
                'user' => ['id', 'name', 'email', 'role'],
                'token',
            ]);
    });

    test('registration requires valid email', function () {
        $response = $this->postJson('/api/auth/register', [
            'name' => 'Test User',
            'email' => 'invalid-email',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    });

    test('registration requires password confirmation', function () {
        $response = $this->postJson('/api/auth/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'different',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['password']);
    });
});

describe('Login', function () {
    test('users can login with correct credentials', function () {
        $user = User::factory()->create([
            'password' => bcrypt('password123'),
        ]);

        $response = $this->postJson('/api/auth/login', [
            'email' => $user->email,
            'password' => 'password123',
        ]);

        $response->assertOk()
            ->assertJsonStructure([
                'message',
                'user',
                'token',
            ]);
    });

    test('users cannot login with incorrect password', function () {
        $user = User::factory()->create([
            'password' => bcrypt('password123'),
        ]);

        $response = $this->postJson('/api/auth/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $response->assertStatus(422);
    });
});

describe('Logout', function () {
    test('authenticated users can logout', function () {
        $user = User::factory()->create();
        $token = $user->createToken('test-token')->plainTextToken;

        $response = $this->withToken($token)
            ->postJson('/api/auth/logout');

        $response->assertOk()
            ->assertJson(['message' => 'Logged out successfully.']);
    });

    test('unauthenticated users cannot logout', function () {
        $response = $this->postJson('/api/auth/logout');

        $response->assertStatus(401);
    });
});

describe('User Profile', function () {
    test('authenticated users can view their profile', function () {
        $user = User::factory()->create();
        $token = $user->createToken('test-token')->plainTextToken;

        $response = $this->withToken($token)
            ->getJson('/api/auth/user');

        $response->assertOk()
            ->assertJsonStructure(['id', 'name', 'email']);
    });

    test('authenticated users can update their profile', function () {
        $user = User::factory()->create();
        $token = $user->createToken('test-token')->plainTextToken;

        $response = $this->withToken($token)
            ->putJson('/api/auth/profile', [
                'name' => 'Updated Name',
            ]);

        $response->assertOk();
        expect($user->fresh()->name)->toBe('Updated Name');
    });
});
