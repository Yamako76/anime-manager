<?php

namespace App\Services\Api\FolderAnimeRelation\State;

use App\Models\FolderAnimeRelation;
use Carbon\Carbon;

class FolderAnimeRelationStateDeleted extends BaseFolderAnimeRelationState
{
    /**
     * フォルダに紐付けたアニメを有効化する。
     *
     * @param \App\Models\FolderAnimeRelation $folderAnimeRelation
     * @return \App\Models\FolderAnimeRelation
     */
    public function activate(FolderAnimeRelation $folderAnimeRelation): \App\Models\FolderAnimeRelation
    {
        $now = Carbon::now();
        $folderAnimeRelation->status = FolderAnimeRelation::STATUS_ACTIVE;
        $folderAnimeRelation->latest_changed_at = $now;
        $folderAnimeRelation->updated_at = $now;
        $folderAnimeRelation->save();
        return $folderAnimeRelation;
    }
}
