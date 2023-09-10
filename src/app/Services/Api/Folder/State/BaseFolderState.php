<?php

namespace App\Services\Api\Folder\State;

use App\Models\Folder;

abstract class BaseFolderState implements FolderState
{
    /**
     * フォルダをを有効化する。
     *
     * @param \App\Models\Folder $folder
     * @return \App\Models\Folder
     */
    public function activate(Folder $folder): \App\Models\Folder
    {
        throw new InvalidFolderStateChangeException(`不正なステータス変更が行われようとしました。[{$folder->status} -> active]`);
    }

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
        throw new InvalidFolderStateChangeException(`不正なステータス変更が行われようとしました。[{$folder->status} -> deleted]`);
    }
}
