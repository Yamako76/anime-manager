<?php

namespace App\Http\Controllers\Api\Anime\Create;

use App\Http\Controllers\Controller;
use App\Http\Requests\AnimeRequest;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{

    public function index(AnimeRequest $request): \Illuminate\Http\JsonResponse
    {

        $userId = Auth::id();

        \AnimeService::createAnimeRecord($userId, $request->name, $request->memo);
        return \response()->json([], 201);
    }
}
