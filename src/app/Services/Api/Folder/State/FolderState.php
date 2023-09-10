<?php

namespace App\Services\Api\Folder\State;

use App\Models\Folder;

interface FolderState
{
    /**
     * フォルダを有効化する。
     *
     * @param Folder $folder
     * @return \App\Models\Folder
     */
    public function activate(Folder $folder): \App\Models\Folder;

    /**
     * フォルダを削除する。
     *
     * 厳密にはデータベースからの削除は行わない。
     * フォルダのステータスを「deleted」に変更する。
     *
     * @param Folder $folder
     * @return Folder
     */
    public function delete(Folder $folder): \App\Models\Folder;
}
