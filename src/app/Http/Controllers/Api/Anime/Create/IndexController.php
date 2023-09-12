<?php

namespace App\Http\Controllers\Api\Anime\Create;

use App\Http\Controllers\Controller;
use App\Http\Requests\AnimeRequest;
use App\Services\Api\Anime\State\AnimeStateNotFoundException;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{

    /**
     * @param AnimeRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(AnimeRequest $request): \Illuminate\Http\JsonResponse
    {

        $userId = Auth::id();

        // アニメを作成します。
        try {
            \AnimeService::CreateAnime($userId, $request->name, $request->memo);
        } catch (AnimeStateNotFoundException $e) {
            \Log::error($e);
            return \response()->json([], 500);
        } catch (\Exception $e) {
            \Log::error("アニメの作成処理中、予期せぬエラーが発生しました。調査が必要です。", $e->getTrace());
            return \response()->json([], 500);
        }

        return \response()->json([], 200);
    }
}
