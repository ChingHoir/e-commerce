<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;

class ProjectPolicy
{
    /**
     * Determine if the user can view the project.
     * - Admin: can view all projects
     * - Manager: can view their own projects
     * - Staff: can view projects that contain tasks assigned to them
     */
    public function view(User $user, Project $project): bool
    {
        // Admin can view all projects
        if ($user->hasRole('admin')) {
            return true;
        }

        // Manager can view their own projects
        if ($user->hasRole('manager')) {
            return $project->created_by === $user->id;
        }

        // Staff can view projects that contain tasks assigned to them
        if ($user->hasRole('staff')) {
            return $project->tasks()
                ->where('assigned_to', $user->id)
                ->exists();
        }

        return false;
    }

    /**
     * Determine if the user can create projects.
     * Only managers and admins can create projects.
     */
    public function create(User $user): bool
    {
        return $user->hasRole('manager') || $user->hasRole('admin');
    }

    /**
     * Determine if the user can update the project.
     * - Admin: can update all projects
     * - Manager: can update their own projects
     */
    public function update(User $user, Project $project): bool
    {
        // Admin can update all projects
        if ($user->hasRole('admin')) {
            return true;
        }

        // Manager can update their own projects
        if ($user->hasRole('manager')) {
            return $project->created_by === $user->id;
        }

        return false;
    }

    /**
     * Determine if the user can delete the project.
     * - Admin: can delete all projects
     * - Manager: can delete their own projects
     */
    public function delete(User $user, Project $project): bool
    {
        // Admin can delete all projects
        if ($user->hasRole('admin')) {
            return true;
        }

        // Manager can delete their own projects
        if ($user->hasRole('manager')) {
            return $project->created_by === $user->id;
        }

        return false;
    }
}
