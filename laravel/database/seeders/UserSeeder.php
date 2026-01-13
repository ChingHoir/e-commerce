<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin user
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => bcrypt('password'),
            ]
        );
        $adminRole = Role::where('name', 'admin')->first();
        if ($adminRole && !$adminUser->roles->contains($adminRole)) {
            $adminUser->roles()->attach($adminRole);
        }

        // Manager user
        $managerUser = User::firstOrCreate(
            ['email' => 'manager@example.com'],
            [
                'name' => 'Manager User',
                'password' => bcrypt('password'),
            ]
        );
        $managerRole = Role::where('name', 'manager')->first();
        if ($managerRole && !$managerUser->roles->contains($managerRole)) {
            $managerUser->roles()->attach($managerRole);
        }

        // Staff users
        $staffRole = Role::where('name', 'staff')->first();
        
        $staff1 = User::firstOrCreate(
            ['email' => 'staff1@example.com'],
            [
                'name' => 'Staff User 1',
                'password' => bcrypt('password'),
            ]
        );
        if ($staffRole && !$staff1->roles->contains($staffRole)) {
            $staff1->roles()->attach($staffRole);
        }

        $staff2 = User::firstOrCreate(
            ['email' => 'staff2@example.com'],
            [
                'name' => 'Staff User 2',
                'password' => bcrypt('password'),
            ]
        );
        if ($staffRole && !$staff2->roles->contains($staffRole)) {
            $staff2->roles()->attach($staffRole);
        }
    }
}
