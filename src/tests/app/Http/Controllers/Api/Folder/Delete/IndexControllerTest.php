<?php

namespace Tests\app\Http\Controllers\Api\Folder\Delete;

use App\Models\Folder;
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
        $folder = new Folder([
            'user_id' => 1,
            'id' => 1,
            'name' => 'フォルダ',
            'status' => 'active',
            'latest_changed_at' => '2023-9-28 08:00:00',
            'created_at' => '2023-9-20 12:30:00',
            'updated_at' => '2023-9-25 14:45:00',
        ]);

        \FolderService::shouldReceive('getFolderByIdAndUserId')
            ->andReturn($folder)
            ->once();

        $response = $this->json('DELETE', "/api/folders/{$folder->id}");
        $response->assertStatus(200);
    }

    public function test_error_delete_folder()
    {
        // $folderIdが整数以外の場合400を返す。
        $folderId = "d";
        $response = $this->json('DELETE', "/api/folders/{$folderId}");
        $response->assertStatus(400);

        // フォルダが存在しない場合404を返す。
        \FolderService::shouldReceive('getFolderByIdAndUserId')
            ->andReturn(null)
            ->once();
        $response = $this->json('DELETE', "/api/folders/1");
        $response->assertStatus(404);
    }
}

