<?php

namespace App\Providers;

use App\Models\Team;
use App\Policies\TeamPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Auth\Access\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Team::class => TeamPolicy::class,
        'App\Post' => 'App\Policies\OkrPolicy',
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
            return ($user->role == 1);
        });
        // マネージャー以上（管理者＆会社＆部署）に許可
        Gate::define('manager-higher', function ($user) {
            return ($user->role > 0 && $user->role <= 4);
        });
        // 全員に許可
        Gate::define('user-higher', function ($user) {
            return ($user->role > 0 && $user->role <= 5);
        });
    }
}
