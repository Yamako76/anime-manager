<?php

namespace App\Services\Api\Folder;


use App\Models\Folder;
use App\Services\Api\Folder\State\FolderStateNotFoundException;
use Carbon\Carbon;

class FolderService
{
    /**
     * 特定のユーザーに関連するフォルダ一覧を取得する。
     *
     * @param int $userId
     * @param int $currentPage
     * @param int $paginateUnit
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getFolderListByUserId(
        int    $userId,
        int    $currentPage,
        int    $paginateUnit = 20,
    ): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        // ソート順を指定してクエリを構築
        $query = Folder::query()->where('user_id', '=', $userId)->where('status', '=', Folder::STATUS_ACTIVE);
        // ページネーションを適用してアニメ一覧を取得
        $folderList = $query->paginate($paginateUnit, ['*'], 'page', $currentPage);
        return $folderList;
    }

    /**
     * フォルダのレコードを追加します。
     *
     * @param int $userId
     * @param string $name
     * @return \App\Models\Folder
     */
    public function createFolderRecord(int $userId, string $name): \App\Models\Folder
    {
        $now = Carbon::now();
        $folder = new Folder();
        $folder->user_id = $userId;
        $folder->name = $name;
        $folder->status = Folder::STATUS_ACTIVE;
        $folder->latest_changed_at = $now;
        $folder->created_at = $now;
        $folder->updated_at = $now;
        $folder->save();
        return $folder;
    }

    /**
     * ユーザーIDとフォルダIDからフォルダを取得します。
     * @param int $animeId
     * @param int $userId
     * @param bool $usePrimary
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
     */

    public function getFolderByIdAndUserId(int $animeId, int $userId, bool $usePrimary = false): mixed
    {
        $query = $usePrimary ? Folder::onWriteConnection() : Folder::query();
        $folder = $query
            ->where("id", "=", $animeId)
            ->where("user_id", "=", $userId)
            ->first();
        return $folder;
    }

    /**
     * ユーザーIDとフォルダの名前からフォルダを取得します。
     * @param int $userId
     * @param string $animeName
     * @param bool $usePrimary
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
     */
    public function getFolderByUserIdAndName(int $userId, string $animeName, bool $usePrimary = false): mixed
    {
        $query = $usePrimary ? Folder::onWriteConnection() : Folder::query();
        $folder = $query
            ->where("user_id", "=", $userId)
            ->where("name", "=", $animeName)
            ->first();
        return $folder;
    }

    /**
     * フォルダの追加を行います。
     * ユーザーId と フォルダの名前から、既にそのフォルダが存在しているか検索します。
     * 存在していない場合、レコードにフォルダを追加します。
     * 存在している場合、
     * フォルダの status カラムが active の場合、そのままフォルダを返します。
     * フォルダの status カラムが deleted の場合、 status を active に変更します。
     *
     * @param int $userId
     * @param string $name
     * @return \App\Models\Folder
     * @throws FolderStateNotFoundException
     */
    public function createFolder(int $userId, string $name): \App\Models\Folder
    {
        /** @var Folder $folder */
        $folder = $this->getFolderByUserIdAndName($userId, $name);
        if (is_null($folder)) {
            $folder = $this->createFolderRecord($userId, $name);
            return $folder;
        }
        if ($folder->status == Folder::STATUS_ACTIVE) {
            return $folder;
        }
        if ($folder->status == Folder::STATUS_DELETED) {
            $folder = $folder->toState()->activate($folder);
            return $folder;
        }
        throw new FolderStateNotFoundException(
            `該当のフォルダステータスが存在しません。["status": {$folder->status}, "userId": {$folder->user_id}, "folderId": {$folder->id}]`
        );
    }

    /**
     * フォルダデータのレコードを更新します。
     *
     * @param Folder $folder
     * @param string $name
     * @return \App\Models\Folder
     */
    public function updateFolderRecord(Folder $folder, string $name): \App\Models\Folder
    {
        $now = Carbon::now();
        $folder->name = $name;
        $folder->latest_changed_at = $now;
        $folder->updated_at = $now;
        $folder->save();
        return $folder;
    }

}
