<?php

namespace Tests\app\Http\Controllers\Api\Anime\Search;

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

    public function test_success_search_anime_list()
    {
        $query = "1";
        $animeList = [
            [
                'user_id' => 1,
                'id' => 1,
                'name' => 'アニメ1',
                'memo' => 'memo',
                'status' => 'active',
                'latest_changed_at' => '2023-9-28 08:00:00',
                'created_at' => '2023-9-20 12:30:00',
                'updated_at' => '2023-9-25 14:45:00',
            ],
            [
                'user_id' => 1,
                'id' => 2,
                'name' => 'アニメ2',
                'memo' => 'memo',
                'status' => 'active',
                'latest_changed_at' => '2023-10-27 10:15:00',
                'created_at' => '2023-10-15 18:20:00',
                'updated_at' => '2023-10-26 09:30:00',
            ],
        ];

        \AnimeService::shouldReceive('searchAnime')
            ->andReturn($animeList[0])
            ->once();

        $response = $this->json('GET', "/api/anime-list/search?q={$query}");
        $response->assertStatus(200);
        $this->assertStringContainsString(json_encode($animeList[0]), $response->content());
    }

    public function test_error_search_anime_list()
    {
        // queryが""の場合
        $query = "";
        $response = $this->json('GET', "/api/anime-list/search?q={$query}");
        $response->assertStatus(422);

        // queryがundefinedの場合
        $response = $this->json('GET', "/api/anime-list/search?q=");
        $response->assertStatus(422);

        // queryがnullの場合
        $response = $this->json('GET', "/api/anime-list/search?q");
        $response->assertStatus(422);
    }
}

