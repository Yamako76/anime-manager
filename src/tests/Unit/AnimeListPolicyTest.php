<?php

namespace Tests\Unit;

use App\Models\Anime;
use App\Models\User;
use App\Policies\AnimeListPolicy;
use PHPUnit\Framework\TestCase;

class AnimeListPolicyTest extends TestCase
{
    /**
     * AnimeListPolicyのバリデーション機能テスト
     * - UserのIDとAnimeのuserIdが一致する場合
     */
    public function testView_valid_user(): void
    {
        $animeListPolicy = new AnimeListPolicy();
        $user = new User();
        $user->user_id = 1;
        $anime = new Anime();
        $anime->user_id = 1;
        $this->assertTrue($animeListPolicy->view($user, $anime));
    }

    /**
     * AnimeListPolicyのバリデーション機能テスト
     * - UserのIDとAnimeのuserIdが一致しない場合
     */
    public function testView_invalid_user(): void
    {
        $animeListPolicy = new AnimeListPolicy();
        $user = new User();
        $user->user_id = 1;
        $anime = new Anime();
        $anime->user_id = 2;
        $this->assertFalse($animeListPolicy->view($user, $anime));
    }
}
