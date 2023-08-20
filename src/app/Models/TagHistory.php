<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int id
 * @property int tag_id
 * @property int user_id
 * @property string name
 * @property string status
 * @property string created_at
 * @property string updated_at
 * @property string deleted_at
 *
 * @property Tag $tag
 *
 */
class TagHistory extends Model
{
    protected $table = 'tag_histories';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */

    public function tag(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Tag::class);
    }
}
