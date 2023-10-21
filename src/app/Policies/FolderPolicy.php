<?php

namespace App\Policies;

use App\Models\Folder;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FolderPolicy
{
    use HandlesAuthorization;

    /**
     * フォルダへのアクセス権限がユーザーであるかどうかを判定します。
     */
    public function view(User $user, Folder $folder): \Illuminate\Auth\Access\Response|bool
    {
        return $user->user_id === $folder->user_id;
    }
}
