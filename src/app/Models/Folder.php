<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Ramsey\Collection\Collection;

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
 * @property FolderHistory[]|Collection $folderHistories
 *
 * @property User $user
 */
class Folder extends Model
{
    protected $table = 'folders';

    const STATUS_ACTIVE = "active";
    const STATUS_DELETED = "deleted";

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */

    public function animeList(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Anime::class, 'folder_anime_relations', 'folder_id', 'anime_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function folderHistories(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(FolderHistory::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}
