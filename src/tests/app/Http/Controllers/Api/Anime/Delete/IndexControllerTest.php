<?php

namespace Tests\app\Http\Controllers\Api\Anime\Delete;

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

    public function test_success_delete_anime()
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

        \AnimeService::shouldReceive('getAnimeByIdAndUserId')
            ->with($anime->id, $userId)
            ->andReturn($anime)
            ->once();

        $response = $this->json('DELETE', "/api/anime-list/{$anime->id}");
        $response->assertStatus(200);
    }

    public function test_error_delete_anime()
    {
        $userId = Auth::id();
        // アニメが存在しない場合404を返す。
        \AnimeService::shouldReceive('getAnimeByIdAndUserId')
            ->with(1, $userId)
            ->andReturn(null)
            ->once();
        $response = $this->json('DELETE', "/api/anime-list/1");
        $response->assertStatus(404);
    }
}

