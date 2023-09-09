<?php

namespace App\Services\Api\Anime\State;

use App\Models\Anime;

interface AnimeState
{
    /**
     * アニメを有効化する。
     *
     * @param \App\Models\Anime $anime
     * @return \App\Models\Anime
     */
    public function activate(Anime $anime): \App\Models\Anime;

    /**
     * アニメを削除する。
     *
     * 厳密にはデータベースからの削除は行わない。
     * アニメのステータスを「deleted」に変更する。
     *
     * @param \App\Models\Anime $anime
     * @return \App\Models\Anime
     */
    public function delete(Anime $anime): \App\Models\Anime;
}
