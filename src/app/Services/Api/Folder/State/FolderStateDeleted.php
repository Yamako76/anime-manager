<?php

namespace App\Services\Api\Folder\State;

use App\Models\Folder;
use Carbon\Carbon;

class FolderStateDeleted extends BaseFolderState
{
    /**
     * フォルダをを有効化する。
     *
     * @param \App\Models\Folder $folder
     * @return \App\Models\Folder
     */
    public function activate(Folder $folder): \App\Models\Folder
    {
        $now = Carbon::now();
        $folder->status = Folder::STATUS_ACTIVE;
        $folder->latest_changed_at = $now;
        $folder->updated_at = $now;
        $folder->save();
        return $folder;
    }
}
