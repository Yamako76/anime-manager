<?php

namespace App\Services\Api\Anime;

use App\Models\Anime;

class AnimeService
{
    /**
     * 特定のユーザーに関連するアニメ一覧を取得する。
     *
     * 取得順は「sortType」によって変更する。
     * - created_atの場合: アニメの登録順
     *
     * @param int $userId
     * @param int $paginateUnit
     * @param string $sortType
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getAnimeListByUserId(
        int    $userId,
        int    $currentPage,
        int    $paginateUnit = 20,
        string $sortType = 'created_at'
    ): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        $animeList = Anime::query()
            ->where('user_id', '=', $userId)
            ->paginate($paginateUnit, ['*'], 'page', $currentPage);
        return $animeList;
    }
}
