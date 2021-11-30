<?php

namespace App\Providers;

use App\Enums\Role;
use App\Models\Team;
use App\Policies\TeamPolicy;
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
        'App\Okr' => 'App\Policies\OkrPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // 開発者のみ許可
        Gate::define('admin-only', function ($user) {
            return $user->role === Role::ADMIN;
        });
        // マネージャー以上（管理者＆会社＆部署）に許可
        Gate::define('manager-higher', function ($user) {
            return $user->role === Role::ADMIN ||
                $user->role === Role::COMPANY ||
                $user->role === Role::DEPARTMENT ||
                $user->role === Role::MANAGER;
        });
        // 全員に許可
        Gate::define('member-higher', function ($user) {
            return $user->role === Role::ADMIN ||
                $user->role === Role::COMPANY ||
                $user->role === Role::DEPARTMENT ||
                $user->role === Role::MANAGER ||
                $user->role === Role::MEMBER;
        });
    }
}
