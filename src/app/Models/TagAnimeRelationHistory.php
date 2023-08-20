<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int id
 * @property int tag_anime_relation_id
 * @property int user_id
 * @property int tag_id
 * @property int anime_id
 * @property string status
 * @property string deleted_at
 * @property string created_at
 * @property string updated_at
 *
 * @property TagAnimeRelation $tagAnimeRelation
 *
 */
class TagAnimeRelationHistory extends Model
{
    protected $table = 'tag_anime_relation_histories';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */

    public function tagAnimeRelation(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(TagAnimeRelation::class);
    }
}
