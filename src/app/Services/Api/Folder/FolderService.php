<?php

namespace App\Services\Api\Folder;


use App\Models\Folder;
use Illuminate\Support\Carbon;

class FolderService
{
    public function createFolderRecord(int $userId, string $name): \App\Models\Folder
    {
        $folder = new Folder();
        $folder->user_id = $userId;
        $folder->name = trim($name);
        $folder->status = "active";
        $folder->latest_changed_at = Carbon::now();
        $folder->save();
        return $folder;
    }
}
