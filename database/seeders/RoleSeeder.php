<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        Role::create([
            'name' => 'admin',
            'permissions' => [
                'users.view',
                'users.create',
                'users.update',
                'users.delete',
                'programs.view',
                'programs.create',
                'programs.update',
                'programs.delete',
                'products.view',
                'products.create',
                'products.update',
                'products.delete',
                'enrollments.view',
                'enrollments.approve',
                'enrollments.reject',
                'commissions.view',
                'commissions.approve',
                'commissions.reject',
                'payouts.view',
                'payouts.process',
                'payouts.approve',
                'settings.view',
                'settings.update',
                'reports.view',
            ],
        ]);

        Role::create([
            'name' => 'affiliate',
            'permissions' => [
                'programs.view',
                'products.view',
                'enrollments.view',
                'enrollments.apply',
                'tracking.view',
                'tracking.create',
                'commissions.view',
                'payouts.view',
                'payouts.request',
                'reports.view.own',
            ],
        ]);
    }
}
