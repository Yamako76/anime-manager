<?php

namespace App\Http\Controllers\Api\Folder;

use App\Http\Controllers\Controller;
use App\Models\Folder;

class FolderController extends Controller
{
    public function index($folderId): \Illuminate\Http\JsonResponse
    {

        $userId = \Auth::id();

        /** @var Folder $folder */
        $folder = \FolderService::getFolderByIdAndUserId($folderId, $userId);
        if (is_null($folder)) {
            return \response()->json([], 404);
        }

        if ($folder->status == Folder::STATUS_DELETED) {
            return \response()->json([], 404);
        }

        return \response()->json($folder, 200);
    }
}
