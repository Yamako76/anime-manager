<?php

namespace Tests\Unit;

use App\Models\Anime;
use App\Models\FolderAnimeRelation;
use App\Models\User;
use App\Policies\AnimeListPolicy;
use App\Policies\FolderAnimePolicy;
use PHPUnit\Framework\TestCase;

class FolderAnimePolicyTest extends TestCase
{
    /**
     * FolderAnimePolicyのバリデーション機能テスト
     * - UserのIDとFolderAnimeRelationのuserIdが一致する場合
     */
    public function testView_valid_user(): void
    {
        $folderAnimeRelationPolicy = new FolderAnimePolicy();
        $user = new User();
        $user->user_id = 1;
        $folderAnimeRelation = new FolderAnimeRelation();
        $folderAnimeRelation->user_id = 1;
        $this->assertTrue($folderAnimeRelationPolicy->view($user, $folderAnimeRelation));
    }

    /**
     * FolderAnimePolicyのバリデーション機能テスト
     * - UserのIDとFolderAnimeRelationのuserIdが一致しない場合
     */
    public function testView_invalid_user(): void
    {
        $folderAnimeRelationPolicy = new AnimeListPolicy();
        $user = new User();
        $user->user_id = 1;
        $folderAnimeRelation = new Anime();
        $folderAnimeRelation->user_id = 2;
        $this->assertFalse($folderAnimeRelationPolicy->view($user, $folderAnimeRelation));
    }
}
