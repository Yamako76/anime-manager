<?php

namespace App\Http\Controllers\Anime;

use App\Http\Controllers\Controller;
use App\Models\Anime;
use Inertia\Inertia;
use Inertia\Response;

class AnimeController extends Controller
{

    public function index($animeId): Response
    {

        // TODO statusがdeletedだった時のエラーハンドリング

        $userId = \Auth::id();
        /** @var Anime $anime */
        $anime = \AnimeService::getAnimeByIdAndUserId($animeId, $userId);

        return Inertia::render('Anime/Anime', [
            "name" => $anime->name
        ]);
    }
}
