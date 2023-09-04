<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int id
 * @property int user_id
 * @property int folder_id
 * @property int anime_id
 * @property string status
 * @property string deleted_at
 * @property string created_at
 *
 * @property Folder $folder
 *
 */
class FolderHistory extends Model
{
    protected $table = 'folder_histories';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */

    public function folder(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Folder::class);
    }
}
