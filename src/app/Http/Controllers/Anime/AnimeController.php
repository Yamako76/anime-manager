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

        // TODO: animeId のバリデーション
        $userId = \Auth::id();
        /** @var Anime $anime */
        $anime = \AnimeService::getAnimeByIdAndUserId($animeId, $userId);

        if (is_null($anime)) {
            abort(404);
        }

        if ($anime->status == Anime::STATUS_DELETED) {
            abort(404);
        }
        // TODO 戻り値にmemoの追加
        return Inertia::render('Anime/Anime', [
            "name" => $anime->name
        ]);
    }
}
