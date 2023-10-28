<?php

namespace Tests\app\Http\Controllers\Api\Anime\Update;

use App\Models\Anime;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Auth;
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
        $userId = Auth::id();
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
        $anime->save();

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

        $data = [
            'name' => 'anime',
            'memo' => 'memo',
        ];

        \AnimeService::shouldReceive('getAnimeByIdAndUserId')
            ->with($anime->id, $userId)
            ->andReturn($anime)
            ->once();


        \AnimeService::shouldReceive('updateAnimeRecord')
            ->with($anime, $data['name'], $data['memo'])
            ->andReturn($updatedAnime)
            ->once();

        $response = $this->json('PUT', "/api/anime-list/{$anime->id}", $data);
        $response->assertStatus(200);
    }

    public function test_error_update_anime()
    {
        // アニメが存在しない場合
        \AnimeService::shouldReceive('getAnimeByIdAndUserId')
            ->andReturn(null)
            ->once();
        $response = $this->json('PUT', "/api/anime-list/1", ['name' => 'anime', 'memo' => 'memo']);
        $response->assertStatus(404);

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
        $anime->save();

        // nameがない場合
        $response = $this->json('PUT', "/api/anime-list/{$anime->id}", []);
        $response->assertStatus(422);

        // name = ""の場合
        $response = $this->json('PUT', "/api/anime-list/{$anime->id}", ['name' => "", 'memo' => 'memo']);
        $response->assertStatus(422);

        // name = ""の場合
        $str = 'abcdefghijklmnopqrstuvwxyz0123456789';
        $name = substr(str_shuffle(str_repeat($str, 10)), 0, 201);
        $response = $this->json('PUT', "/api/anime-list/{$anime->id}", ['name' => $name, 'memo' => 'memo']);
        $response->assertStatus(422);
    }
}

