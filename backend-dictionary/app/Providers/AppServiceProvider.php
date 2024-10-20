<?php

namespace App\Providers;

use App\Models\User;
use App\Models\UserFavoriteWord;
use App\Models\UserHistoryWord;
use App\Models\Word;
use App\Repositories\Eloquents\User\UserEloquent;
use App\Repositories\Eloquents\User\UserFavoriteEloquent;
use App\Repositories\Eloquents\User\UserHistoryEloquent;
use App\Repositories\Eloquents\Word\WordEloquent;
use Illuminate\Http\Resources\Json\JsonResource;
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

        $this->app->bind('App\Repositories\Interfaces\Word\WordInterface', 'App\Repositories\Eloquents\Word\WordEloquent');
        $this->app->bind('App\Repositories\Interfaces\Word\WordInterface', function () {
            return new WordEloquent(new Word());
        });

        $this->app->bind('App\Repositories\Interfaces\User\UserFavoriteInterface', 'App\Repositories\Eloquents\User\UserFavoriteEloquent');
        $this->app->bind('App\Repositories\Interfaces\User\UserFavoriteInterface', function () {
            return new UserFavoriteEloquent(new UserFavoriteWord());
        });

        $this->app->bind('App\Repositories\Interfaces\User\UserHistoryInterface', 'App\Repositories\Eloquents\User\UserHistoryEloquent');
        $this->app->bind('App\Repositories\Interfaces\User\UserHistoryInterface', function () {
            return new UserHistoryEloquent(new UserHistoryWord());
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        JsonResource::withoutWrapping();
    }
}
