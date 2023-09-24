<?php

namespace App\Services\Api\FolderAnimeRelation\State;

use App\Models\FolderAnimeRelation;

interface FolderAnimeRelationState
{
    /**
     * フォルダに紐付けたアニメを有効化する。
     *
     * @param \App\Models\FolderAnimeRelation $folderAnimeRelation
     * @return \App\Models\FolderAnimeRelation
     */
    public function activate(FolderAnimeRelation $folderAnimeRelation): \App\Models\FolderAnimeRelation;

    /**
     * フォルダに紐付けたアニメを削除する。
     *
     * 厳密にはデータベースからの削除は行わない。
     * フォルダアニメのステータスを「deleted」に変更する。
     *
     * @param \App\Models\FolderAnimeRelation $folderAnimeRelation
     * @return \App\Models\FolderAnimeRelation
     */
    public function delete(FolderAnimeRelation $folderAnimeRelation): \App\Models\FolderAnimeRelation;
}
