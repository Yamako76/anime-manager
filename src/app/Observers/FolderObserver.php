<?php

namespace App\Observers;

use App\Models\Folder;
use App\Models\FolderHistory;
use Carbon\Carbon;

class FolderObserver
{
    /**
     * フォルダが保存された際に履歴テーブルに履歴保存します。
     *
     * @param \App\Models\Folder $folder
     * @return void
     */
    public function saved(Folder $folder): void
    {
        $folderHistory = new FolderHistory();
        $folderHistory->user_id = $folder->user_id;
        $folderHistory->folder_id = $folder->id;
        $folderHistory->name = $folder->name;
        $folderHistory->status = $folder->status;
        $folderHistory->deleted_at = $folder->deleted_at;
        $folderHistory->created_at = Carbon::now();
        $folderHistory->save();
    }
}
