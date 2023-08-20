<?php

namespace App\Http\Controllers\Api\Anime;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{

    public function index(Request $request): \Illuminate\Http\JsonResponse
    {
        /**
         * TODO: エラーハンドリング
         *      - パラメータpageがnullの場合
         *      - 存在しないpageを指定した場合
         *      - 違うuserIdを指定した場合
         *      - 予期しない場合
         */
        $currentPage = $request->query('page');
        $userId = Auth::id();

        // TODO: ソートオプションを追加する
        $animeList = \AnimeService::getAnimeListByUserId($userId, $currentPage, 20, 'created_at');
        return \response()->json($animeList->toArray());
    }
}
