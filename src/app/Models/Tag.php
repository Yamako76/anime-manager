<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;


/**
 * @property int id
 * @property int user_id
 * @property string name
 * @property string status
 * @property string deleted_at
 * @property string latest_changed_at
 * @property string created_at
 * @property string updated_at
 *
 * @property Anime[]|Collection $animeList
 * @property TagHistory[]|Collection $tagHistories
 *
 * @property User $user
 *
 */
class Tag extends Model
{
    protected $table = 'tags';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */

    public function animeList(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Anime::class, 'tag_anime_relations', 'tag_id', 'anime_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tagHistories(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(TagHistory::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}
