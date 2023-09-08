<?php

namespace App\Http\Controllers\Api\Folder;

use App\Http\Controllers\Controller;
use App\Models\Folder;

class FolderController extends Controller
{
    public function index(Folder $folder): \Illuminate\Http\JsonResponse
    {
        return \response()->json($folder, 200);
    }
}
