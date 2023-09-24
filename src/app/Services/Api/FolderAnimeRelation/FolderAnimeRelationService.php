<?php

namespace App\Services\Api\FolderAnimeRelation;


use App\Models\Anime;
use App\Models\Folder;
use App\Models\FolderAnimeRelation;
use App\Services\Api\FolderAnimeRelation\State\FolderAnimeRelationStateNotFoundException;
use Carbon\Carbon;

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
                $query->latest('id');
                break;
            // TODO title順のソート追加
            default:
                throw new \InvalidArgumentException(`不正なソートタイプが入力されました。[{$sortType}]`);
        }

        // ページネーションを適用してアニメ一覧を取得
        $animeList = $query->paginate($paginateUnit, ['*'], 'page', $currentPage);
        return $animeList;
    }

    /**
     * ユーザーIDとフォルダの名前からフォルダを取得します。
     *
     * @param int $userId
     * @param string $folderName
     * @param bool $usePrimary
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
     */
    public function getFolderIdByUserIdAndFolderName(int $userId, string $folderName, bool $usePrimary = false): mixed
    {
        $query = $usePrimary ? Folder::onWriteConnection() : Folder::query();
        $fodler = $query
            ->where("user_id", "=", $userId)
            ->where("name", "=", $folderName)
            ->first();
        return $fodler;
    }

    /**
     * ユーザーIDとアニメの名前からアニメを取得します。
     *
     * @param int $userId
     * @param string $animeName
     * @param bool $usePrimary
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
     */
    public function getAnimeIdByUserIdAndAnimeName(int $userId, string $animeName, bool $usePrimary = false): mixed
    {
        $query = $usePrimary ? Anime::onWriteConnection() : Anime::query();
        $anime = $query
            ->where("user_id", "=", $userId)
            ->where("name", "=", $animeName)
            ->first();
        return $anime;
    }

    /**
     *  ユーザーIDとフォルダIDとアニメIDからフォルダアニメを取得します。
     *
     * @param int $userId
     * @param int $folderId
     * @param int $animeId
     * @param bool $usePrimary
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
     */
    public function getFolderAnimeRelationByUserIdAndFolderIdAndAnimeId(int $userId, int $folderId, int $animeId, bool $usePrimary = false): mixed
    {
        $query = $usePrimary ? FolderAnimeRelation::onWriteConnection() : FolderAnimeRelation::query();
        $folderAnimeRelation = $query
            ->where("user_id", "=", $userId)
            ->where("folder_id", "=", $folderId)
            ->where("anime_id", "=", $animeId)
            ->first();
        return $folderAnimeRelation;
    }

    /**
     * フォルダアニメのレコードを追加します。
     *
     * @param int $userId
     * @param int $folderId
     * @param int $animeId
     * @return \App\Models\FolderAnimeRelation
     */
    public function createFolderAnimeRelationRecord(int $userId, int $folderId, int $animeId): \App\Models\FolderAnimeRelation
    {
        $now = Carbon::now();
        $folderAnimeRelation = new FolderAnimeRelation();
        $folderAnimeRelation->user_id = $userId;
        $folderAnimeRelation->folder_id = $folderId;
        $folderAnimeRelation->anime_id = $animeId;
        $folderAnimeRelation->status = FolderAnimeRelation::STATUS_ACTIVE;
        $folderAnimeRelation->latest_changed_at = $now;
        $folderAnimeRelation->created_at = $now;
        $folderAnimeRelation->updated_at = $now;
        $folderAnimeRelation->save();
        return $folderAnimeRelation;
    }

    /**
     * フォルダにアニメの追加を行います。
     * ユーザーId と フォルダId と アニメId から、既にそのアニメがフォルダに存在しているか検索します。
     * 存在していない場合、レコードにアニメを追加します。
     * 存在している場合、
     * フォルダアニメの status カラムが active の場合、そのままフォルダアニメを返します。
     * フォルダアニメの status カラムが deleted の場合、 status を active に変更します。
     *
     * @param int $userId
     * @param int $folderID
     * @param int $animeId
     * @return \App\Models\FolderAnimeRelation
     * @throws FolderAnimeRelationStateNotFoundException
     */
    public function createFolderAnimeRelation(int $userId, int $folderID, int $animeId): \App\Models\FolderAnimeRelation
    {
        /** @var FolderAnimeRelation $folderAnimeRelation */
        $folderAnimeRelation = $this->getFolderAnimeRelationByUserIdAndFolderIdAndAnimeId($userId, $folderID, $animeId);
        if (is_null($folderAnimeRelation)) {
            $folderAnimeRelation = $this->createFolderAnimeRelationRecord($userId, $folderID, $animeId);
            return $folderAnimeRelation;
        }
        if ($folderAnimeRelation->status == FolderAnimeRelation::STATUS_ACTIVE) {
            return $folderAnimeRelation;
        }
        if ($folderAnimeRelation->status == FolderAnimeRelation::STATUS_DELETED) {
            $folderAnimeRelation = $folderAnimeRelation->toState()->activate($folderAnimeRelation);
            return $folderAnimeRelation;
        }
        throw new FolderAnimeRelationStateNotFoundException(
            `該当のアニメステータスが存在しません。["status": {$folderAnimeRelation->status}, "userId": {$folderAnimeRelation->user_id},"folderId": {$folderAnimeRelation->folder_id}, "animeId": {$folderAnimeRelation->anime_id}]`
        );
    }

}
