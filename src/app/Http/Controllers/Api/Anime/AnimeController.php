<?php

namespace App\Http\Controllers\Api\Anime;

use App\Http\Controllers\Controller;
use App\Models\Anime;

class AnimeController extends Controller
{
    public function index($animeId): \Illuminate\Http\JsonResponse
    {

        $userId = \Auth::id();

        /** @var Anime $anime */
        $anime = \AnimeService::getAnimeByIdAndUserId($animeId, $userId);
        if (is_null($anime)) {
            return \response()->json([], 404);
        }

        if ($anime->status == Anime::STATUS_DELETED) {
            return \response()->json([], 404);
        }

        return \response()->json($anime, 200);
    }
}
