<?php

namespace App\Http\Controllers\Api\Anime\Delete;

use App\Http\Controllers\Controller;
use App\Models\Anime;
use App\Services\Api\Anime\State\InvalidAnimeStateChangeException;

class IndexController extends Controller
{
    /**
     * @param $animeId
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($animeId): \Illuminate\Http\JsonResponse
    {
        $userId = \Auth::id();

        // $animeId が整数でない場合
        if (!is_numeric($animeId) || (int)$animeId != $animeId) {
            return \response()->json([], 400);
        }

        // 削除するアニメを取得します。
        /** @var Anime $anime */
        $anime = \AnimeService::getAnimeByIdAndUserId($animeId, $userId);
        if (is_null($anime)) {
            return \response()->json([], 404);
        }

        // アニメを削除します。
        try {
            $anime = $anime->toState()->delete($anime);
        } catch (InvalidAnimeStateChangeException $e) {
            \Log::warning($e);
            return \response()->json([], 400);
        } catch (\Exception $e) {
            \Log::error("アニメの削除処理中、予期せぬエラーが発生しました。調査が必要です。", $e);
            return \response()->json([], 500);
        }

        return \response()->json([], 200);
    }
}
