<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin has all permissions
        $adminRole = Role::where('name', 'admin')->first();
        if ($adminRole) {
            $adminRole->permissions()->sync(Permission::pluck('id')->toArray());
        }

        // Manager can manage products and categories, but not users
        $managerRole = Role::where('name', 'manager')->first();
        if ($managerRole) {
            $managerPermissions = Permission::whereIn('name', [
                'products.create',
                'products.update',
                'products.delete',
                'category.create',
                'category.update',
                'category.delete',
            ])->pluck('id')->toArray();
            $managerRole->permissions()->sync($managerPermissions);
        }

        // Staff can only view/create products (limited permissions)
        $staffRole = Role::where('name', 'staff')->first();
        if ($staffRole) {
            $staffPermissions = Permission::whereIn('name', [
                'products.create',
            ])->pluck('id')->toArray();
            $staffRole->permissions()->sync($staffPermissions);
        }
    }
}
