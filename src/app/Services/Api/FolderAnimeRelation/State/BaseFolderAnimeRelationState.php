<?php

namespace App\Services\Api\FolderAnimeRelation\State;

use App\Models\FolderAnimeRelation;

abstract class BaseFolderAnimeRelationState implements FolderAnimeRelationState
{
    /**
     * フォルダに紐付けたアニメを有効化する。
     *
     * @param \App\Models\FolderAnimeRelation $folderAnimeRelation
     * @return \App\Models\FolderAnimeRelation
     */
    public function activate(FolderAnimeRelation $folderAnimeRelation): \App\Models\FolderAnimeRelation
    {
        throw new InvalidFolderAnimeRelationStateChangeException(`不正なステータス変更が行われようとしました。[{$folderAnimeRelation->status} -> active]`);
    }

    /**
     * フォルダに紐付けたアニメを削除する。
     *
     * 厳密にはデータベースからの削除は行わない。
     * フォルダアニメのステータスを「deleted」に変更する。
     *
     * @param \App\Models\FolderAnimeRelation $folderAnimeRelation
     * @return \App\Models\FolderAnimeRelation
     */
    public function delete(FolderAnimeRelation $folderAnimeRelation): \App\Models\FolderAnimeRelation
    {
        throw new InvalidFolderAnimeRelationStateChangeException(`不正なステータス変更が行われようとしました。[{$folderAnimeRelation->status} -> deleted]`);
    }
}
