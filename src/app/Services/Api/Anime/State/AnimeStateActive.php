<?php

namespace App\Services\Api\Anime\State;

use App\Models\Anime;
use Carbon\Carbon;

class AnimeStateActive extends BaseAnimeState
{
    /**
     * アニメを削除する。
     *
     * 厳密にはデータベースからの削除は行わない。
     * アニメのステータスを「deleted」に変更する。
     *
     * @param \App\Models\Anime $anime
     * @return \App\Models\Anime
     */
    public function delete(Anime $anime): \App\Models\Anime
    {
        $now = Carbon::now();
        $anime->status = Anime::STATUS_DELETED;
        $anime->deleted_at = $now;
        $anime->latest_changed_at = $now;
        $anime->updated_at = $now;
        $anime->save();
        return $anime;
    }
}
