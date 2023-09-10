<?php

namespace App\Http\Controllers\Api\Anime\Create;

use App\Http\Controllers\Controller;
use App\Http\Requests\AnimeRequest;
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

        if (is_null($request->memo)) {
            return \response()->json([], 400);
        }

        // 新しいアニメを作成します。
        \AnimeService::CreateAnime($userId, $request->name, $request->memo);
        return \response()->json([], 201);
    }
}
