<?php

namespace App\Models;

use App\Services\Api\Anime\State\AnimeStateActive;
use App\Services\Api\Anime\State\AnimeStateDeleted;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 *
 * @property int id
 * @property string name
 * @property int user_id
 * @property string status
 * @property string memo
 * @property string deleted_at
 * @property string latest_changed_at
 * @property string created_at
 * @property string updated_at
 *
 * @property Folder[]|Collection $folders
 * @property AnimeHistory[]|Collection $animeHistories
 *
 * @property User $user
 *
 */
class Anime extends Model
{
    protected $table = 'animes';

    const STATUS_ACTIVE = "active";
    const STATUS_DELETED = "deleted";

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */

    public function folders(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Folder::class, 'folder_anime_relations', 'anime_id', 'folder_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function animeHistories(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(AnimeHistory::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    /**
     * アニメのモデルからアニメのステータスクラスへ変換する。
     *
     * @return \App\Services\Api\Anime\State\AnimeState
     * @throws \InvalidArgumentException
     */
    public function toState(): \App\Services\Api\Anime\State\AnimeState
    {
        if ($this->status == self::STATUS_ACTIVE) {
            return new AnimeStateActive();
        } else if ($this->status == self::STATUS_DELETED) {
            return new AnimeStateDeleted();
        } else {
            throw new \InvalidArgumentException(`ステータスが存在しません。[{$this->status}]`);
        }
    }
}
