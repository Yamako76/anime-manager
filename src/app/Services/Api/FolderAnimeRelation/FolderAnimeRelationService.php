<?php

namespace App\Services\Api\FolderAnimeRelation;


use App\Models\FolderAnimeRelation;

class FolderAnimeRelationService
{
    /**
     * @param int $userId
     * @param int $folderId
     * @param int $currentPage
     * @param int $paginateUnit
     * @param string $sortType
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
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

        switch ($sortType) {
            case 'created_at':
                $query->orderBy('created_at');
                break;
            case 'latest':
                $query->latest('anime_id');
                break;
            // TODO title順のソート追加
            default:
                throw new \InvalidArgumentException(`不正なソートタイプが入力されました。[{$sortType}]`);
        }

        // ページネーションを適用してアニメ一覧を取得
        $animeList = $query->paginate($paginateUnit, ['*'], 'page', $currentPage);
        return $animeList;
    }
}
