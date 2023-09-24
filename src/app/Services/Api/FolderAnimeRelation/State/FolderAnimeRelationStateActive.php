<?php

namespace App\Services\Api\FolderAnimeRelation\State;

use App\Models\FolderAnimeRelation;
use Carbon\Carbon;

class FolderAnimeRelationStateActive extends BaseFolderAnimeRelationState
{
    /**
     * フォルダに紐付けたアニメを削除する。
     *
     * 厳密にはデータベースからの削除は行わない。
     * アニメのステータスを「deleted」に変更する。
     *
     * @param \App\Models\FolderAnimeRelation $folderAnimeRelation
     * @return \App\Models\FolderAnimeRelation
     */
    public function delete(FolderAnimeRelation $folderAnimeRelation): \App\Models\FolderAnimeRelation
    {
        $now = Carbon::now();
        $folderAnimeRelation->status = FolderAnimeRelation::STATUS_DELETED;
        $folderAnimeRelation->deleted_at = $now;
        $folderAnimeRelation->latest_changed_at = $now;
        $folderAnimeRelation->updated_at = $now;
        $folderAnimeRelation->save();
        return $folderAnimeRelation;
    }
}
