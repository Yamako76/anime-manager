<?php

namespace App\Http\Controllers\Api\Folder;

use App\Http\Controllers\Controller;
use App\Models\Folder;

class FolderController extends Controller
{
    public function index($id): \Illuminate\Http\JsonResponse
    {
        // 指定されたIDに基づいてフォルダを取得
        $folder = Folder::find($id);

        if (!$folder) {
            return response()->json([], 404);
        }

        return \response()->json($folder);
    }
}
