<?php

namespace Tests\app\Http\Controllers\Api\Anime\Update;

use App\Models\Anime;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class IndexControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function setUp(): void
    {
        parent::setUp();
        $user = User::factory()->create();
        $this->actingAs($user);
    }

    public function test_success_update_anime()
    {
        $anime = new Anime([
            'user_id' => 1,
            'id' => 1,
            'name' => 'アニメ',
            'memo' => 'メモ',
            'status' => 'active',
            'latest_changed_at' => '2023-9-28 08:00:00',
            'created_at' => '2023-9-20 12:30:00',
            'updated_at' => '2023-9-25 14:45:00',
        ]);

        $updatedAnime = new Anime([
            'user_id' => 1,
            'id' => 1,
            'name' => 'anime',
            'memo' => 'memo',
            'status' => 'active',
            'latest_changed_at' => '2023-9-28 08:00:00',
            'created_at' => '2023-9-20 12:30:00',
            'updated_at' => '2023-9-25 14:45:00',
        ]);

        \AnimeService::shouldReceive('getAnimeByIdAndUserId')
            ->andReturn($anime)
            ->once();


        \AnimeService::shouldReceive('updateAnimeRecord')
            ->andReturn($updatedAnime)
            ->once();

        $response = $this->json('PUT', "/api/anime-list/{$anime->id}", ['name' => 'anime', 'memo' => 'memo']);
        $response->assertStatus(200);
    }

    public function test_error_update_anime()
    {
        // $animeIdが整数以外の場合
        $animeId = "d";
        $response = $this->json('PUT', "/api/anime-list/{$animeId}", ['name' => 'anime', 'memo' => 'memo']);
        $response->assertStatus(400);

        // アニメが存在しない場合
        \AnimeService::shouldReceive('getAnimeByIdAndUserId')
            ->andReturn(null)
            ->once();
        $response = $this->json('PUT', "/api/anime-list/1", ['name' => 'anime', 'memo' => 'memo']);
        $response->assertStatus(404);

        // nameがない場合
        $response = $this->json('PUT', "/api/anime-list/1", []);
        $response->assertStatus(422);

        // name = ""の場合
        $response = $this->json('PUT', "/api/anime-list/1", ['name' => "", 'memo' => 'memo']);
        $response->assertStatus(422);

        // name = ""の場合
        $str = 'abcdefghijklmnopqrstuvwxyz0123456789';
        $name = substr(str_shuffle(str_repeat($str, 10)), 0, 201);
        $response = $this->json('PUT', "/api/anime-list/1", ['name' => $name, 'memo' => 'memo']);
        $response->assertStatus(422);
    }
}

