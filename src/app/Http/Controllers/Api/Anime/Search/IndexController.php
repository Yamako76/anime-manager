<?php

namespace App\Http\Controllers\Api\Anime\Search;

use App\Http\Controllers\Controller;
use App\Http\Requests\SearchRequest;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{

    /**
     * @param SearchRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(SearchRequest $request): \Illuminate\Http\JsonResponse
    {
        $userId = Auth::id();
        $keyWord = trim($request->q);
        // アニメを検索します。
        $animes = \AnimeService::searchAnime($userId, $keyWord);

        return \response()->json($animes, 200);
    }
}
