<?php

namespace App\Http\Controllers\Folder;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;

class IndexController extends Controller
{

    public function index(): Response
    {
        return Inertia::render('Folder/Index', []);
    }
}
