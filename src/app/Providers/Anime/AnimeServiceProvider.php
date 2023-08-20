<?php

namespace App\Providers\Anime;

use App\Services\Api\Anime\AnimeService;
use Illuminate\Support\ServiceProvider;

class AnimeServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->app->bind('AnimeService', function () {
            return new AnimeService();
        });
    }
}
