<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int id
 * @property int user_id
 * @property int anime_id
 * @property int tag_id
 * @property string status
 * @property string deleted_at
 * @property string latest_changed_at
 * @property string created_at
 * @property string updated_at
 *
 * @property TagAnimeRelationHistory[]|Collection $tagAnimeRelationHistories
 *
 * @property User $user
 *
 */
class TagAnimeRelation extends Model
{
    protected $table = 'tag_anime_relations';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */

    public function tagAnimeRelationHistories(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(TagAnimeRelationHistory::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}
