<?php

namespace App\Providers;

use App\Models\User;
use App\Repositories\Eloquents\User\UserEloquent;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind('App\Repositories\Interfaces\User\UserInterface', 'App\Repositories\Eloquents\User\UserEloquent');
        $this->app->bind('App\Repositories\Interfaces\User\UserInterface', function () {
            return new UserEloquent(new User());
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
