<?php

namespace App\Services\Api\FolderAnimeRelation;


use App\Models\FolderAnimeRelation;

class FolderAnimeRelationService
{
    public function getAnimeListByUserIdAndFolderId(
        int    $userId,
        int    $folderId,
        int    $currentPage,
        int    $paginateUnit = 20,
        string $sortType = 'created_at'): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        $query = FolderAnimeRelation::query()->where('user_id', '=', $userId)
            ->where('folder_id', '=', $folderId)
            ->where('status', '=', FolderAnimeRelation::STATUS_ACTIVE);
        // ページネーションを適用してアニメ一覧を取得
        $animeList = $query->paginate($paginateUnit, ['*'], 'page', $currentPage);
        return $animeList;
    }
}
