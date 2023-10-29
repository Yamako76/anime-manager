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
        // $animeId が整数でない場合
        if (!is_numeric($animeId) || (int)$animeId != $animeId) {
            return Inertia::render('Error/NotFound');
        }

        $userId = \Auth::id();
        /** @var Anime $anime */
        $anime = \AnimeService::getAnimeByIdAndUserId($animeId, $userId);

        if (is_null($anime)) {
            return Inertia::render('Error/NotFound');
        }

        if ($anime->status == Anime::STATUS_DELETED) {
            return Inertia::render('Error/NotFound');
        }
        return Inertia::render('Anime/Anime', [
            "name" => $anime->name,
            "memo" => $anime->memo,
            "id" => $anime->id,
        ]);
    }
}
