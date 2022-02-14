<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(\App\Repositories\Interfaces\UserRepositoryInterface::class, \App\Repositories\UserRepository::class);
        $this->app->bind(\App\Repositories\Interfaces\ObjectiveRepositoryInterface::class, \App\Repositories\ObjectiveRepository::class);
        $this->app->bind(\App\Repositories\Interfaces\CompanyRepositoryInterface::class, \App\Repositories\CompanyRepository::class);
        $this->app->bind(\App\Repositories\Interfaces\KeyResultRepositoryInterface::class, \App\Repositories\KeyResultRepository::class);
        $this->app->bind(\App\Repositories\Interfaces\QuarterRepositoryInterface::class, \App\Repositories\QuarterRepository::class);
        $this->app->bind(\App\Repositories\Interfaces\CompanyGroupRepositoryInterface::class, \App\Repositories\CompanyGroupRepository::class);
        $this->app->bind(\App\Repositories\Interfaces\DepartmentRepositoryInterface::class, \App\Repositories\DepartmentRepository::class);
        $this->app->bind(\App\Repositories\Interfaces\SlackRepositoryInterface::class, \App\Repositories\SlackRepository::class);
    }

    public function boot()
    {
    }
}
