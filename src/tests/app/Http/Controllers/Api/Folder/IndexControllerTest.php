<?php

namespace Tests\app\Http\Controllers\Api\Folder;

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

    public function test_success_get_folder_list()
    {
        $folderList = [
            [
                'user_id' => 1,
                'id' => 1,
                'name' => 'フォルダ1',
                'status' => 'active',
                'latest_changed_at' => '2023-9-28 08:00:00',
                'created_at' => '2023-9-20 12:30:00',
                'updated_at' => '2023-9-25 14:45:00',
            ],
            [
                'user_id' => 1,
                'id' => 2,
                'name' => 'フォルダ2',
                'status' => 'active',
                'latest_changed_at' => '2023-10-27 10:15:00',
                'created_at' => '2023-10-15 18:20:00',
                'updated_at' => '2023-10-26 09:30:00',
            ],
        ];

        \FolderService::shouldReceive("getFolderListByUserId")->andReturn(
            new LengthAwarePaginator($folderList, count($folderList), 20, 1)
        )->once();

        $response = $this->json('GET', '/api/folders?page=1&sort=created_at');
        $response->assertStatus(200);
        $this->assertStringContainsString(json_encode($folderList), $response->content());
    }

    public function test_error_get_folder_list()
    {

        // 現在のページデータが渡されなかった場合、ぺジネーション機能を使用できないため、400を返すテスト。
        $response = $this->json('GET', '/api/folders?sort=created_at');
        $response->assertStatus(400);

        $folderList = [
            [
                'user_id' => 1,
                'id' => 1,
                'name' => 'フォルダ1',
                'status' => 'active',
                'latest_changed_at' => '2023-9-28 08:00:00',
                'created_at' => '2023-9-20 12:30:00',
                'updated_at' => '2023-9-25 14:45:00',
            ],
            [
                'user_id' => 1,
                'id' => 2,
                'name' => 'フォルダ2',
                'status' => 'active',
                'latest_changed_at' => '2023-10-27 10:15:00',
                'created_at' => '2023-10-15 18:20:00',
                'updated_at' => '2023-10-26 09:30:00',
            ],
        ];

        // そもそも存在しないページへのアクセスが行われた場合、リソースが存在しないため404を返却するテスト。
        \FolderService::shouldReceive("getFolderListByUserId")->andReturn(
            new LengthAwarePaginator($folderList, count($folderList), 20, 1)
        )->once();
        $response = $this->json('GET', '/api/folders?page=2&sort=created_at');
        $response->assertStatus(404);

        \FolderService::shouldReceive("getFolderListByUserId")->andReturn(
            new LengthAwarePaginator($folderList, count($folderList), 20, 1)
        )->once();
        $response = $this->json('GET', '/api/folders?page=0&sort=created_at');
        $response->assertStatus(404);
    }
}

