<?php

namespace App\Services\Api\Anime;

use App\Models\Anime;
use Carbon\Carbon;

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
     * @throws \InvalidArgumentException
     */
    public function getAnimeListByUserId(
        int    $userId,
        int    $currentPage,
        int    $paginateUnit = 20,
        string $sortType = 'created_at'
    ): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        // ソート順を指定してクエリを構築
        $query = Anime::query()->where('user_id', '=', $userId)->where('status', '=', Anime::STATUS_ACTIVE);
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
                throw new \InvalidArgumentException(`不正なソートタイプが入力されました。[{$sortType}]`);
        }
        // ページネーションを適用してアニメ一覧を取得
        $animeList = $query->paginate($paginateUnit, ['*'], 'page', $currentPage);
        return $animeList;
    }

    /**
     *アニメのレコードを追加します。
     *
     * @param int $userId
     * @param string $name
     * @param string|null $memo
     * @return \App\Models\Anime
     */
    public function createAnimeRecord(int $userId, string $name, ?string $memo): \App\Models\Anime
    {
        $now = Carbon::now();
        $anime = new Anime();
        $anime->user_id = $userId;
        $anime->name = $name;
        $anime->memo = $memo;
        $anime->status = Anime::STATUS_ACTIVE;
        $anime->latest_changed_at = $now;
        $anime->created_at = $now;
        $anime->updated_at = $now;
        $anime->save();
        return $anime;
    }

    /**
     * ユーザーIDとアニメIDからアニメを取得します。
     *
     * @param int $animeId
     * @param int $userId
     * @param bool $usePrimary
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
     */
    public function getAnimeByIdAndUserId(int $animeId, int $userId, bool $usePrimary = false): mixed
    {
        $query = $usePrimary ? Anime::onWriteConnection() : Anime::query();
        $anime = $query
            ->where("id", "=", $animeId)
            ->where("user_id", "=", $userId)
            ->first();
        return $anime;
    }

    /**
     * ユーザーIDとアニメの名前からアニメを取得します。
     *
     * @param int $userId
     * @param string $animeName
     * @param bool $usePrimary
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
     */
    public function getAnimeByUserIdAndName(int $userId, string $animeName, bool $usePrimary = false): mixed
    {
        $query = $usePrimary ? Anime::onWriteConnection() : Anime::query();
        $anime = $query
            ->where("user_id", "=", $userId)
            ->where("name", "=", $animeName)
            ->first();
        return $anime;
    }

    /**
     * アニメの追加を行います。
     *
     * @param int $userId
     * @param string $name
     * @param string|null $memo
     * @return \App\Models\Anime
     * @throws \Exception
     */
    public function CreateAnime(int $userId, string $name, ?string $memo): \App\Models\Anime
    {
        /** @var Anime $anime */
        $anime = $this->getAnimeByUserIdAndName($userId, $name);
        if (is_null($anime)) {
            $anime = $this->createAnimeRecord($userId, $name, $memo);
        } else {
            if ($anime->status == Anime::STATUS_ACTIVE) {
                // TODO エラーハンドリングできれば400を返したい
                throw new \Exception("そのアニメはすでに存在しています。");
            } elseif ($anime->status == Anime::STATUS_DELETED) {
                $anime = $anime->toState()->activate($anime);
            }
        }
        return $anime;
    }

    /**
     * @param Anime $anime
     * @param string $name
     * @param string|null $memo
     * @return \App\Models\Anime
     */
    public function UpdateAnimeRecord(Anime $anime, string $name, ?string $memo): \App\Models\Anime
    {
        $now = Carbon::now();
        $anime->name = $name;
        $anime->memo = $memo;
        $anime->latest_changed_at = $now;
        $anime->updated_at = $now;
        $anime->save();
        return $anime;
    }

}
