<?php

namespace App\Services\Api\Folder\State;

use App\Models\Folder;
use Carbon\Carbon;

class FolderStateActive extends BaseFolderState
{
    /**
     * フォルダを削除する。
     *
     * 厳密にはデータベースからの削除は行わない。
     * フォルダのステータスを「deleted」に変更する。
     *
     * @param \App\Models\Folder $folder
     * @return \App\Models\Folder
     */
    public function delete(Folder $folder): \App\Models\Folder
    {
        $now = Carbon::now();
        $folder->status = Folder::STATUS_DELETED;
        $folder->deleted_at = $now;
        $folder->latest_changed_at = $now;
        $folder->updated_at = $now;
        $folder->save();
        return $folder;
    }
}
