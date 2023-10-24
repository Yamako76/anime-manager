<?php

namespace App\Models;

use App\Services\Api\Folder\State\FolderStateActive;
use App\Services\Api\Folder\State\FolderStateDeleted;
use App\Services\Api\Folder\State\FolderStateNotFoundException;
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


    protected $fillable = ['user_id', 'name', 'status', 'latest_changed_at',];

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

    /**
     * フォルダのモデルからフォルダのステータスクラスへ変換する。
     *
     * @return \App\Services\Api\Folder\State\FolderState
     * @throws FolderStateNotFoundException
     */
    public function toState(): \App\Services\Api\Folder\State\FolderState
    {
        if ($this->status == self::STATUS_ACTIVE) {
            return new FolderStateActive();
        } else if ($this->status == self::STATUS_DELETED) {
            return new FolderStateDeleted();
        } else {
            throw new FolderStateNotFoundException(`ステータスが存在しません。[{$this->status}]`);
        }
    }

}
