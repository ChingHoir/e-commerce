<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $staff = User::whereHas('roles', fn($q) => $q->where('name', 'staff'))->get();
        $manager = User::whereHas('roles', fn($q) => $q->where('name', 'manager'))->first();
        $projects = Project::all();

        if ($projects->isEmpty() || $staff->isEmpty() || !$manager) {
            return;
        }

        $staffIndex = 0;
        foreach ($projects as $project) {
            for ($i = 1; $i <= 3; $i++) {
                $assignedStaff = $staff[$staffIndex % $staff->count()];
                $staffIndex++;

                Task::create([
                    'title' => "Task {$i} for {$project->name}",
                    'description' => "Complete this task as part of the {$project->name} project",
                    'project_id' => $project->id,
                    'assigned_to' => $assignedStaff->id,
                    'status' => $i === 1 ? 'in_progress' : 'pending',
                    'due_date' => now()->addDays($i * 5),
                    'created_by' => $manager->id,
                ]);
            }
        }
    }
}
