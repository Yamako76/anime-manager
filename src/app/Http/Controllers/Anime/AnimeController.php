<?php

namespace App\Http\Controllers\Anime;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class AnimeController extends Controller
{

    public function index(Request $request): Response
    {
        return Inertia::render('Anime/Anime', [
            "name" => "ドラゴンボール"
        ]);
    }
}
