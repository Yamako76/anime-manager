<?php

namespace App\Http\Controllers\Anime\Create;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;

class IndexController extends Controller
{

    public function index(): Response
    {
        return Inertia::render('Anime/Create/Index', []);
    }
}
