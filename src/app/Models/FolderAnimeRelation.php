<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;


/**
 * @property int id
 * @property int folder_id
 * @property int user_id
 * @property int anime_id
 * @property string status
 * @property string deleted_at
 * @property string latest_changed_at
 * @property string created_at
 * @property string updated_at
 *
 * @property FolderAnimeRelationHistory[]|Collection $folderAnimeRelationHistories
 *
 * @property User $user
 *
 */
class FolderAnimeRelation extends Model
{
    protected $table = 'folder_anime_relations';

    const STATUS_ACTIVE = "active";
    const STATUS_DELETED = "deleted";

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */

    public function folderAnimeRelationHistories(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(FolderAnimeRelationHistory::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}
