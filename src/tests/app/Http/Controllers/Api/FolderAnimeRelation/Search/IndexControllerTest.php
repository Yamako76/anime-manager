<?php

namespace Tests\app\Http\Controllers\Api\FolderAnimeRelation\Search;

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

    public function test_success_search_folder_anime_list()
    {
        $folderId = 1;
        $query = "1";

        $animeList = [
            [
                'name' => 'アニメ1',
                'anime_id' => 1,
                'folder_id' => 1,
                'folder_anime_latest_changed_at' => '2023-9-25 14:45:00',
            ],
            [
                'name' => 'アニメ2',
                'anime_id' => 2,
                'folder_id' => 1,
                'folder_anime_latest_changed_at' => '2023-10-26 09:30:00',
            ],
        ];

        \FolderAnimeRelationService::shouldReceive('searchFolderAnime')
            ->andReturn(collect($animeList[0]))
            ->once();

        $response = $this->json('GET', "/api/folders/{$folderId}/anime-list/search?q={$query}");
        $response->assertStatus(200);
        $this->assertStringContainsString(json_encode($animeList[0]), $response->content());
    }

    public function test_error_search_folder_anime_list()
    {
        // queryが""の場合
        $query = "";
        $response = $this->json('GET', "/api/folders/1/anime-list/search?q={$query}");
        $response->assertStatus(422);

        // queryがundefinedの場合
        $response = $this->json('GET', "/api/folders/1/anime-list/search?q=");
        $response->assertStatus(422);

        // queryがnullの場合
        $response = $this->json('GET', "/api/folders/1/anime-list/search?q");
        $response->assertStatus(422);
    }
}

