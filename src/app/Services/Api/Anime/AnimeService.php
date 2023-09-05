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
     * - latestの場合: アニメの最新順
     * - titleの場合: アニメのタイトル順
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
        // ソート順を指定してクエリを構築
        $query = Anime::query()->where('user_id', '=', $userId);

        switch ($sortType) {
            case 'created_at':
                $query->orderBy('created_at');
                break;
            case 'latest':
                $query->latest('id');
                break;
            case 'title':
                $query->orderBy('name');
                break;
            default:
                break;
        }

        // ページネーションを適用してアニメ一覧を取得
        $animeList = $query->paginate($paginateUnit, ['*'], 'page', $currentPage);

        return $animeList;
    }
}
