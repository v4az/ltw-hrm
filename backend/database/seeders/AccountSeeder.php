<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AccountSeeder extends Seeder
{
    /**
     * Seed one demo account per role. Run after RolePermissionSeeder.
     *
     * Default password for every demo account: Password123!
     */
    public function run(): void
    {
        $accounts = [
            ['name' => 'System Admin', 'email' => 'admin@ltw-hrm.test', 'role' => 'admin'],
            ['name' => 'HR Manager', 'email' => 'hr@ltw-hrm.test', 'role' => 'hr'],
            ['name' => 'Team Manager', 'email' => 'manager@ltw-hrm.test', 'role' => 'manager'],
            ['name' => 'Employee', 'email' => 'employee@ltw-hrm.test', 'role' => 'employee'],
        ];

        foreach ($accounts as $account) {
            $user = User::firstOrCreate(
                ['email' => $account['email']],
                [
                    'name' => $account['name'],
                    'password' => Hash::make('Password123!'),
                    'email_verified_at' => now(),
                    'is_active' => true,
                ]
            );

            $user->syncRoles([$account['role']]);
        }
    }
}
