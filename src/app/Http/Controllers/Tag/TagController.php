<?php

namespace App\Http\Controllers\Tag;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class TagController extends Controller
{

    public function index(Request $request): Response
    {
        return Inertia::render('Tag/Tag', [
            "name" => "面白い"
        ]);
    }
}
