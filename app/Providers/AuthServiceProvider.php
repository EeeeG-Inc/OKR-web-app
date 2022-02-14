<?php

namespace App\Providers;

use App\Enums\Role;
use App\Models\Team;
use App\Models\User;
use App\Policies\TeamPolicy;
use App\Policies\RolePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Team::class => TeamPolicy::class,
        User::class => RolePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
        $this->adminOnly();
        $this->companyHigher();
        $this->managerHigher();
        $this->memberHigher();
    }

    private function adminOnly(): void
    {
        Gate::define('admin-only', function ($user) {
            return $user->role === Role::ADMIN;
        });
    }

    private function companyHigher(): void
    {
        Gate::define('company-higher', function ($user) {
            return $user->role === Role::COMPANY;
        });
    }

    private function managerHigher(): void
    {
        Gate::define('manager-higher', function ($user) {
            return $user->role === Role::COMPANY ||
                $user->role === Role::DEPARTMENT ||
                $user->role === Role::MANAGER;
        });
    }

    private function memberHigher(): void
    {
        Gate::define('member-higher', function ($user) {
            return $user->role === Role::COMPANY ||
                $user->role === Role::DEPARTMENT ||
                $user->role === Role::MANAGER ||
                $user->role === Role::MEMBER;
        });
    }
}
