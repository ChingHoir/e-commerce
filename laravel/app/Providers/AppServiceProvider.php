<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Admin bypass: admins can perform any action
        Gate::before(function ($user, $ability) {
            return $user->hasRole('admin') ? true : null;
        });

        // Define gates for specific permissions
        Gate::define('users.manage', fn($user) => $user->hasPermission('users.manage'));
        Gate::define('products.create', fn($user) => $user->hasPermission('products.create'));
        Gate::define('products.update', fn($user) => $user->hasPermission('products.update'));
        Gate::define('products.delete', fn($user) => $user->hasPermission('products.delete'));
        Gate::define('category.create', fn($user) => $user->hasPermission('category.create'));
        Gate::define('category.update', fn($user) => $user->hasPermission('category.update'));
        Gate::define('category.delete', fn($user) => $user->hasPermission('category.delete'));
    }
}
