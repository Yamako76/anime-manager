<?php

namespace App\Http\Controllers\Folder;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class FolderController extends Controller
{

    public function index(Request $request): Response
    {
        return Inertia::render('Folder/Folder', [
            "name" => "コメディー"
        ]);
    }
}
