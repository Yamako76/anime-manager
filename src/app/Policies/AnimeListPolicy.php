<?php

namespace App\Policies;

use App\Models\Anime;
use App\Models\Folder;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AnimeListPolicy
{
    use HandlesAuthorization;

    /**
     * アニメへのアクセス権限がユーザーであるかどうかを判定します。
     */
    public function view(User $user, Anime $anime): \Illuminate\Auth\Access\Response|bool
    {
        return $user->user_id === $anime->user_id;
    }
}
