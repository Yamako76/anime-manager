<?php

namespace App\Http\Controllers\Api\Anime\Create;

use App\Http\Controllers\Controller;
use App\Http\Requests\AnimeRequest;
use App\Services\Api\Anime\State\InvalidAnimeStateChangeException;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{

    /**
     * @param AnimeRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function index(AnimeRequest $request): \Illuminate\Http\JsonResponse
    {

        $userId = Auth::id();

        // TODO フロントで直したら消す
        if (is_null($request->memo)) {
            return \response()->json([], 400);
        }

        // アニメの作成処理を実行します。
        try {
            \AnimeService::CreateAnime($userId, $request->name, $request->memo);
        } catch (\Exception $e) {
            \Log::error("アニメの作成処理中、予期せぬエラーが発生しました。調査が必要です。", $e);
            return \response()->json([], 500);
        }

        return \response()->json([], 200);
    }
}
