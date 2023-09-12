<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int id
 * @property int folder_anime_relation_id
 * @property int user_id
 * @property int folder_id
 * @property int anime_id
 * @property string status
 * @property string deleted_at
 * @property string created_at
 *
 * @property FolderAnimeRelation $folderAnimeRelation
 *
 */
class FolderAnimeRelationHistory extends Model
{
    protected $table = 'folder_anime_relation_histories';

    public $timestamps = false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */

    public function folderAnimeRelation(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(FolderAnimeRelation::class);
    }
}
