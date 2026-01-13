<?php

namespace App\Policies;

use App\Models\Category;
use App\Models\User;

class CategoryPolicy
{
    /**
     * Determine if the user can view the category.
     * All authenticated users can view categories.
     */
    public function view(User $user, Category $category): bool
    {
        return true;
    }

    /**
     * Determine if the user can create categories.
     * Only managers and admins can create categories.
     */
    public function create(User $user): bool
    {
        return $user->hasRole('manager') || $user->hasRole('admin');
    }

    /**
     * Determine if the user can update the category.
     * Only managers and admins can update categories.
     */
    public function update(User $user, Category $category): bool
    {
        return $user->hasRole('manager') || $user->hasRole('admin');
    }

    /**
     * Determine if the user can delete the category.
     * Only admins can delete categories.
     */
    public function delete(User $user, Category $category): bool
    {
        return $user->hasRole('admin');
    }
}
