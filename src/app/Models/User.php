<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * @property int user_id
 * @property string name
 * @property string email
 * @property string email_verified_at
 * @property string password
 * @property string remember_token
 * @property string created_at
 * @property string updated_at
 *
 * @property Folder[]|Collection $folders
 * @property Anime[]|Collection $animeList
 * @property FolderAnimeRelation[]|Collection $folderAnimeRelations
 * @property TagAnimeRelation[]|Collection $tagAnimeRelations
 * @property Tag[]|Collection $tags
 *
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'user_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function folders(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Folder::class, 'user_id', 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function animeList(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Anime::class, 'user_id', 'use_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function folderAnimeRelations(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(FolderAnimeRelation::class, 'user_id', 'use_id');
    }
    
}
