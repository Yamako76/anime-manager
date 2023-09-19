<?php

namespace App\Http\Controllers\Folder;

use App\Http\Controllers\Controller;
use App\Models\Folder;
use Inertia\Inertia;
use Inertia\Response;

class FolderController extends Controller
{

    public function index($folderId): Response
    {
        $userId = \Auth::id();

        /** @var Folder $folder */
        $folder = \FolderService::getFolderByIdAndUserId($folderId, $userId);

        if (is_null($folder)) {
            return Inertia::render('Error/NotFound');
        }

        if ($folder->status == Folder::STATUS_DELETED) {
            return Inertia::render('Error/NotFound');
        }

        return Inertia::render('Folder/Folder', [
            "name" => $folder->name
        ]);
    }
}
