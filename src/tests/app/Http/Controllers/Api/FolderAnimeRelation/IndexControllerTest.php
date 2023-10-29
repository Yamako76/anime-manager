<?php

namespace Tests\app\Http\Controllers\Api\FolderAnimeRelation;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Pagination\LengthAwarePaginator;
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

    public function test_success_get_folder_anime_list()
    {
        $folderId = 1;
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

        \FolderAnimeRelationService::shouldReceive("getAnimeListByUserIdAndFolderId")->andReturn(
            new LengthAwarePaginator($animeList, count($animeList), 20, 1)
        )->once();

        $response = $this->json('GET', "/api/folders/{$folderId}/anime-list?page=1&sort=created_at");
        $response->assertStatus(200);
        $this->assertStringContainsString(json_encode($animeList), $response->content());
    }

    public function test_error_get_folder_anime_list()
    {
        $folderId = 1;
        // 現在のページデータが渡されなかった場合、ぺジネーション機能を使用できないため、400を返すテスト。
        $response = $this->json('GET', "/api/folders/{$folderId}/anime-list?sort=created_at");
        $response->assertStatus(400);

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

        // そもそも存在しないページへのアクセスが行われた場合、リソースが存在しないため404を返却するテスト。
        \FolderAnimeRelationService::shouldReceive("getAnimeListByUserIdAndFolderId")->andReturn(
            new LengthAwarePaginator($animeList, count($animeList), 20, 1)
        )->once();
        $response = $this->json('GET', "/api/folders/{$folderId}/anime-list?page=2&sort=created_at");
        $response->assertStatus(404);

        \FolderAnimeRelationService::shouldReceive("getAnimeListByUserIdAndFolderId")->andReturn(
            new LengthAwarePaginator($animeList, count($animeList), 20, 1)
        )->once();
        $response = $this->json('GET', "/api/folders/{$folderId}/anime-list?page=0&sort=created_at");
        $response->assertStatus(404);
    }
}

