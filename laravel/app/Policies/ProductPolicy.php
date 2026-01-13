<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;

class ProductPolicy
{
    /**
     * Determine if the user can view the product.
     * All authenticated users can view products.
     */
    public function view(User $user, Product $product): bool
    {
        return true;
    }

    /**
     * Determine if the user can create products.
     * Only managers and admins can create products.
     */
    public function create(User $user): bool
    {
        return $user->hasRole('manager') || $user->hasRole('admin');
    }

    /**
     * Determine if the user can update the product.
     * Only managers and admins can update products.
     */
    public function update(User $user, Product $product): bool
    {
        return $user->hasRole('manager') || $user->hasRole('admin');
    }

    /**
     * Determine if the user can delete the product.
     * Only admins can delete products.
     */
    public function delete(User $user, Product $product): bool
    {
        return $user->hasRole('admin');
    }
}
