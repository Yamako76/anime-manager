<?php

namespace App\Observers;

use App\Models\FolderAnimeRelation;
use App\Models\FolderAnimeRelationHistory;
use Carbon\Carbon;

class FolderAnimeRelationObserver
{
    /**
     * フォルダが保存された際に履歴テーブルに履歴保存します。
     *
     * @param \App\Models\FolderAnimeRelation $folderAnimeRelation
     * @return void
     */
    public function saved(FolderAnimeRelation $folderAnimeRelation): void
    {
        $folderAnimeRelationHistory = new FolderAnimeRelationHistory();
        $folderAnimeRelationHistory->user_id = $folderAnimeRelation->user_id;
        $folderAnimeRelationHistory->folder_id = $folderAnimeRelation->folder_id;
        $folderAnimeRelationHistory->anime_id = $folderAnimeRelation->anime_id;
        $folderAnimeRelationHistory->status = $folderAnimeRelation->status;
        $folderAnimeRelationHistory->deleted_at = $folderAnimeRelation->deleted_at;
        $folderAnimeRelationHistory->created_at = Carbon::now();
        $folderAnimeRelationHistory->save();
    }
}
