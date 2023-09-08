<?php

namespace App\Http\Controllers\Api\Anime;

use App\Http\Controllers\Controller;
use App\Models\Anime;

class AnimeController extends Controller
{
    public function index(Anime $anime): \Illuminate\Http\JsonResponse
    {
        return \response()->json($anime, 200);
    }
}
