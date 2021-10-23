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
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('announcements.view', 'App\Policies\RolePolicy@view');
        Gate::define('announcements.create', 'App\Policies\RolePolicy@create');
        Gate::define('announcements.update', 'App\Policies\RolePolicy@update');
        Gate::define('announcements.delete', 'App\Policies\RolePolicy@delete');
    }
}
