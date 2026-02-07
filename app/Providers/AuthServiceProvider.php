<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Gate untuk checking role
        Gate::define('isAdmin', function ($user) {
            return $user->isAdmin();
        });

        Gate::define('isPustakawan', function ($user) {
            return $user->isPustakawan();
        });

        Gate::define('isAdminOrPustakawan', function ($user) {
            return $user->isAdminOrPustakawan();
        });

        Gate::define('isUser', function ($user) {
            return $user->isUser();
        });

        Gate::define('isActive', function ($user) {
            return $user->is_active;
        });
    }
}
