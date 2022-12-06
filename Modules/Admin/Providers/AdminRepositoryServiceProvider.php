<?php

namespace Modules\Admin\Providers;

use Illuminate\Support\ServiceProvider;


class AdminRepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
//        $this->app->bind(EloquentRepositoryInterface::class, BaseRepository::class);
//        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
