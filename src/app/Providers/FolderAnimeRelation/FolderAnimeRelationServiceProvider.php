<?php

namespace App\Providers\FolderAnimeRelation;

use App\Services\Api\FolderAnimeRelation\FolderAnimeRelationService;
use Illuminate\Support\ServiceProvider;

class FolderAnimeRelationServiceProvider extends ServiceProvider
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
        $this->app->bind('FolderAnimeRelationService', function () {
            return new FolderAnimeRelationService();
        });
    }
}
