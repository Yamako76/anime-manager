<?php

namespace Tests\app\Http\Controllers\Api\Folder\Update;

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

    public function test_success_update_folder()
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

        $updatedFolder = new Folder([
            'user_id' => 1,
            'id' => 1,
            'name' => 'folder',
            'status' => 'active',
            'latest_changed_at' => '2023-9-28 08:00:00',
            'created_at' => '2023-9-20 12:30:00',
            'updated_at' => '2023-9-25 14:45:00',
        ]);

        \FolderService::shouldReceive('getFolderByIdAndUserId')
            ->andReturn($folder)
            ->once();


        \FolderService::shouldReceive('updateFolderRecord')
            ->andReturn($updatedFolder)
            ->once();

        $response = $this->json('PUT', "/api/folders/{$folder->id}", ['name' => 'folder']);
        $response->assertStatus(200);
    }

    public function test_error_update_folder()
    {
        // $folderIdが整数以外の場合
        $folderId = "d";
        $response = $this->json('PUT', "/api/folders/{$folderId}", ['name' => 'folder']);
        $response->assertStatus(400);

        // フォルダが存在しない場合
        \FolderService::shouldReceive('getFolderByIdAndUserId')
            ->andReturn(null)
            ->once();
        $response = $this->json('PUT', "/api/folders/1", ['name' => 'folder']);
        $response->assertStatus(404);

        // nameがない場合
        $response = $this->json('PUT', "/api/folders/1", []);
        $response->assertStatus(422);

        // name = ""の場合
        $response = $this->json('PUT', "/api/folders/1", ['name' => ""]);
        $response->assertStatus(422);

        // name = ""の場合
        $str = 'abcdefghijklmnopqrstuvwxyz0123456789';
        $name = substr(str_shuffle(str_repeat($str, 10)), 0, 201);
        $response = $this->json('PUT', "/api/folders/1", ['name' => $name]);
        $response->assertStatus(422);
    }
}

