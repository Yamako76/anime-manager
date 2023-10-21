<?php

namespace App\Policies;

use App\Models\FolderAnimeRelation;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FolderAnimePolicy
{
    use HandlesAuthorization;

    /**
     * フォルダ内のアニメのアクセス権限がユーザーであるかどうかを判定します。
     */
    public function view(User $user, FolderAnimeRelation $folderAnime): \Illuminate\Auth\Access\Response|bool
    {
        return $user->user_id === $folderAnime->user_id;
    }
}
