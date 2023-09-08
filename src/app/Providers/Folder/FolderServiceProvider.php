<?php

namespace App\Providers\Folder;

use App\Services\Api\Folder\FolderService;
use Illuminate\Support\ServiceProvider;

class FolderServiceProvider extends ServiceProvider
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
        $this->app->bind('FolderService', function () {
            return new FolderService();
        });
    }
}
