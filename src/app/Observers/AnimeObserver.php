<?php

namespace App\Observers;

use App\Models\Anime;
use App\Models\AnimeHistory;
use Carbon\Carbon;

class AnimeObserver
{
    /**
     * アニメが保存された際に履歴テーブルに履歴保存します。
     *
     * @param \App\Models\Anime $anime
     * @return void
     */
    public function saved(Anime $anime): void
    {
        $animeHistory = new AnimeHistory();
        $animeHistory->user_id = $anime->user_id;
        $animeHistory->anime_id = $anime->id;
        $animeHistory->name = $anime->name;
        $animeHistory->memo = $anime->memo;
        $animeHistory->status = $anime->status;
        $animeHistory->deleted_at = $anime->deleted_at;
        $animeHistory->created_at = Carbon::now();
        $animeHistory->save();
    }
}
