<?php

namespace App\Providers;

use App\Models\Auth\User;
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
        Gate::define('see-users-management', fn (User $user) => $user->super_user);

        Gate::define('delete-users', fn (User $user) => $user->super_user);
    }
}
