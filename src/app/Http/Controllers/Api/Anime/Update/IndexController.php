<?php

namespace App\Http\Controllers\Api\Anime\Update;

use App\Http\Controllers\Controller;
use App\Models\Anime;
use App\Services\Api\Anime\State\InvalidAnimeStateChangeException;

class IndexController extends Controller
{

    public function index($animeId): \Illuminate\Http\JsonResponse
    {

        $userId = \Auth::id();

        // 編集するアニメを取得します。
        /** @var Anime $anime */
        $anime = \AnimeService::getAnimeByIdAndUserId($animeId, $userId);
        if (is_null($anime)) {
            return \response()->json([], 404);
        }

        // アニメの編集処理を実行します。
        try {
            \AnimeService::UpdateAnimeRecord($anime, $anime->name, $anime->memo);
        } catch (\Exception $e) {
            \Log::error("アニメの編集処理中、予期せぬエラーが発生しました。調査が必要です。", $e);
            return \response()->json([], 500);
        }

        return \response()->json([], 200);
    }
}
