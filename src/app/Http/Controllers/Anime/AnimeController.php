<?php

namespace App\Http\Controllers\Anime;

use App\Http\Controllers\Controller;
use App\Models\Anime;
use Inertia\Inertia;
use Inertia\Response;

class AnimeController extends Controller
{

    public function index(Anime $anime): Response
    {
        return Inertia::render('Anime/Anime', [
            "name" => $anime->name
        ]);
    }
}
