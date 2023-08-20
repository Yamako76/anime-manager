<?php

namespace App\Http\Controllers\Top;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;

class IndexController extends Controller
{

    public function index(): Response
    {
        return Inertia::render('Top/Index', []);
    }
}
