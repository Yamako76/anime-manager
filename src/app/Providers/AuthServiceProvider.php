<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Anime;
use App\Models\Folder;
use App\Models\FolderAnimeRelation;
use App\Policies\AnimeListPolicy;
use App\Policies\FolderAnimePolicy;
use App\Policies\FolderPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Anime::class => AnimeListPolicy::class,
        Folder::class => FolderPolicy::class,
        FolderAnimeRelation::class => FolderAnimePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
