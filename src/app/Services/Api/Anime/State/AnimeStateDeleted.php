<?php

namespace App\Services\Api\Anime\State;

use App\Models\Anime;
use Carbon\Carbon;

class AnimeStateDeleted extends BaseAnimeState
{
    /**
     * アニメを有効化する。
     *
     * @param \App\Models\Anime $anime
     * @return \App\Models\Anime
     */
    public function activate(Anime $anime): \App\Models\Anime
    {
        $now = Carbon::now();
        $anime->status = Anime::STATUS_ACTIVE;
        $anime->latest_changed_at = $now;
        $anime->updated_at = $now;
        $anime->save();
        return $anime;
    }
}
