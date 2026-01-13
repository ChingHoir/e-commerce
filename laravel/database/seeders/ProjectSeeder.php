<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get a manager user
        $manager = User::whereHas('roles', fn($q) => $q->where('name', 'manager'))->first();

        if ($manager) {
            Project::create([
                'name' => 'E-commerce Platform Redesign',
                'description' => 'Complete redesign of the e-commerce platform',
                'created_by' => $manager->id,
                'status' => 'active',
            ]);

            Project::create([
                'name' => 'Mobile App Development',
                'description' => 'Develop mobile app for iOS and Android',
                'created_by' => $manager->id,
                'status' => 'active',
            ]);

            Project::create([
                'name' => 'Database Optimization',
                'description' => 'Optimize database queries and indexes',
                'created_by' => $manager->id,
                'status' => 'on_hold',
            ]);
        }
    }
}
