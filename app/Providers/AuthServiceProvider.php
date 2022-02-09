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

        // 管理者のみ許可
        Gate::define('admin-only', function ($user) {
            return $user->role === Role::ADMIN;
        });

        // 会社以上を許可
        Gate::define('company-higher', function ($user) {
            return $user->role === Role::COMPANY;
        });

        // マネージャ以上を許可
        Gate::define('manager-higher', function ($user) {
            return $user->role === Role::COMPANY ||
                $user->role === Role::DEPARTMENT ||
                $user->role === Role::MANAGER;
        });

        // メンバー以上を許可
        Gate::define('member-higher', function ($user) {
            return $user->role === Role::COMPANY ||
                $user->role === Role::DEPARTMENT ||
                $user->role === Role::MANAGER ||
                $user->role === Role::MEMBER;
        });
    }
}
