<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int id
 * @property int anime_id
 * @property int user_id
 * @property string name
 * @property string memo
 * @property string status
 * @property string deleted_at
 * @property string created_at
 *
 * @property Anime $anime
 *
 */
class AnimeHistory extends Model
{
    protected $table = 'anime_histories';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */

    public function anime(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Anime::class);
    }
}
