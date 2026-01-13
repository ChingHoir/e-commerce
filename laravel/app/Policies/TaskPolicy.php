<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;

class TaskPolicy
{
    /**
     * Determine if the user can view the task.
     * - Admin: can view all tasks
     * - Manager: can view tasks in their projects
     * - Staff: can view tasks assigned to them
     */
    public function view(User $user, Task $task): bool
    {
        // Admin can view all tasks
        if ($user->hasRole('admin')) {
            return true;
        }

        // Manager can view tasks in their projects
        if ($user->hasRole('manager')) {
            return $task->project->created_by === $user->id;
        }

        // Staff can view tasks assigned to them
        if ($user->hasRole('staff')) {
            return $task->assigned_to === $user->id;
        }

        return false;
    }

    /**
     * Determine if the user can create tasks.
     * Only managers and admins can create tasks.
     */
    public function create(User $user): bool
    {
        return $user->hasRole('manager') || $user->hasRole('admin');
    }

    /**
     * Determine if the user can update the task.
     * - Admin: can update all tasks
     * - Manager: can update tasks in their projects
     * - Staff: cannot update tasks
     */
    public function update(User $user, Task $task): bool
    {
        // Admin can update all tasks
        if ($user->hasRole('admin')) {
            return true;
        }

        // Manager can update tasks in their projects
        if ($user->hasRole('manager')) {
            return $task->project->created_by === $user->id;
        }

        return false;
    }

    /**
     * Determine if the user can update the task status.
     * - Admin: can update all task statuses
     * - Manager: can update task statuses in their projects
     * - Staff: can update status of tasks assigned to them
     */
    public function updateStatus(User $user, Task $task): bool
    {
        // Admin can update all task statuses
        if ($user->hasRole('admin')) {
            return true;
        }

        // Manager can update task statuses in their projects
        if ($user->hasRole('manager')) {
            return $task->project->created_by === $user->id;
        }

        // Staff can update status of tasks assigned to them
        if ($user->hasRole('staff')) {
            return $task->assigned_to === $user->id;
        }

        return false;
    }

    /**
     * Determine if the user can delete the task.
     * - Admin: can delete all tasks
     * - Manager: can delete tasks in their projects
     */
    public function delete(User $user, Task $task): bool
    {
        // Admin can delete all tasks
        if ($user->hasRole('admin')) {
            return true;
        }

        // Manager can delete tasks in their projects
        if ($user->hasRole('manager')) {
            return $task->project->created_by === $user->id;
        }

        return false;
    }
}
