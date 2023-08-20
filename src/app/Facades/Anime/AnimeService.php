<?php

namespace App\Facades\Anime;

use Illuminate\Support\Facades\Facade;

class AnimeService extends Facade
{
    public static function getFacadeAccessor(): string
    {
        return 'AnimeService';
    }
}
