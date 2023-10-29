<?php

namespace Tests\app\Http\Controllers\Api\FolderAnimeRelation\Delete;

use App\Models\FolderAnimeRelation;
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

    public function test_success_delete_folder()
    {
        $folderAnime = new FolderAnimeRelation([
            'user_id' => 1,
            'id' => 1,
            'folder_id' => 1,
            'anime_id' => 1,
            'status' => 'active',
            'latest_changed_at' => '2023-9-28 08:00:00',
            'created_at' => '2023-9-20 12:30:00',
            'updated_at' => '2023-9-25 14:45:00',
        ]);

        \FolderAnimeRelationService::shouldReceive('getFolderAnimeRelationByUserIdAndFolderIdAndAnimeId')
            ->andReturn($folderAnime)
            ->once();

        $response = $this->json('DELETE', "/api/folders/{$folderAnime->folder_id}/anime-list/{$folderAnime->anime_id}");
        $response->assertStatus(200);
    }

    public function test_error_delete_folder()
    {
        // フォルダ内にアニメが存在しない場合404を返す。
        \FolderAnimeRelationService::shouldReceive('getFolderAnimeRelationByUserIdAndFolderIdAndAnimeId')
            ->andReturn(null)
            ->once();
        $response = $this->json('DELETE', "/api/folders/1/anime-list/1");
        $response->assertStatus(404);
    }
}

