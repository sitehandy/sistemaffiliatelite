<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
*/

uses(Tests\TestCase::class)
    ->in('Feature', 'Unit');

uses(LazilyRefreshDatabase::class)
    ->in('Feature');

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
*/

expect()->extend('toBeOne', function () {
    return $this->toBe(1);
});

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
*/

function createAdmin(): \App\Models\User
{
    $role = \App\Models\Role::firstOrCreate(
        ['name' => 'admin'],
        ['permissions' => ['*']]
    );

    return \App\Models\User::factory()->create([
        'role_id' => $role->id,
    ]);
}

function createAffiliate(): \App\Models\User
{
    $role = \App\Models\Role::firstOrCreate(
        ['name' => 'affiliate'],
        ['permissions' => ['programs.view', 'tracking.create']]
    );

    return \App\Models\User::factory()->create([
        'role_id' => $role->id,
    ]);
}

function createProgram(array $attributes = []): \App\Models\AffiliateProgram
{
    return \App\Models\AffiliateProgram::factory()->create($attributes);
}

function createProduct(array $attributes = []): \App\Models\Product
{
    return \App\Models\Product::factory()->create($attributes);
}
