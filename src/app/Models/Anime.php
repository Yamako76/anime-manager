<?php

namespace App\Models;

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
 * @property string created_at
 * @property string updated_at
 *
 * @property Folder[]|Collection $folders
 * @property Tag[]|Collection $tags
 *
 * @property User $user
 *
 */
class Anime extends Model
{
    protected $table = 'animes';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */

    public function folders(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Folder::class, 'folder_anime_relations', 'anime_id', 'folder_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}
