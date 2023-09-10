<?php

namespace App\Services\Api\Folder;


use App\Models\Folder;
use Carbon\Carbon;

class FolderService
{
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
        $folder->status = "active";
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
     *
     * @param int $userId
     * @param string $name
     * @return \App\Models\Folder
     * @throws \Exception
     */
    public function CreateFolder(int $userId, string $name): \App\Models\Folder
    {
        /** @var Folder $folder */
        $folder = $this->getFolderByUserIdAndName($userId, $name);
        if (is_null($folder)) {
            $folder = $this->createFolderRecord($userId, $name);
        } else {
            if ($folder->status == Folder::STATUS_ACTIVE) {
                // TODO エラーハンドリングできれば400を返したい
                throw new \Exception("そのフォルダはすでに存在しています。");
            } elseif ($folder->status == Folder::STATUS_DELETED) {
                $folder = $folder->toState()->activate($folder);
            }
        }
        return $folder;
    }

}
