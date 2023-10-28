<?php

namespace Tests\app\Http\Controllers\Api\Anime\Create;

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

    public function test_success_create_anime()
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

        $data = [
            'name' => 'アニメ',
            'memo' => 'メモ',
        ];

        \AnimeService::shouldReceive('createAnime')
            ->with($userId, $data['name'], $data['memo'])
            ->andReturn($anime)
            ->once();

        $response = $this->json('POST', '/api/anime-list', $data);
        $response->assertStatus(200);
    }

    public function test_error_create_anime()
    {
        // nameがない場合
        $response = $this->json('POST', '/api/anime-list', []);
        $response->assertStatus(422);

        // name = ""の場合
        $response = $this->json('POST', '/api/anime-list', ['name' => "", 'memo' => 'memo']);
        $response->assertStatus(422);

        // nameが200文字を超える場合
        $str = 'abcdefghijklmnopqrstuvwxyz0123456789';
        $name = substr(str_shuffle(str_repeat($str, 10)), 0, 201);
        $response = $this->json('POST', '/api/anime-list', ['name' => $name, 'memo' => 'memo']);
        $response->assertStatus(422);
    }
}

