<?php

namespace Tests\app\Http\Controllers\Api\Folder\Search;

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

    public function test_success_search_folder_list()
    {
        $query = "1";
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

        \FolderService::shouldReceive('searchFolder')
            ->andReturn($folderList[0])
            ->once();

        $response = $this->json('GET', "/api/folders/search?q={$query}");
        $response->assertStatus(200);
        $this->assertStringContainsString(json_encode($folderList[0]), $response->content());
    }

    public function test_error_search_folder_list()
    {
        // queryが""の場合
        $query = "";
        $response = $this->json('GET', "/api/folders/search?q={$query}");
        $response->assertStatus(422);

        // queryがundefinedの場合
        $response = $this->json('GET', "/api/folders/search?q=");
        $response->assertStatus(422);

        // queryがnullの場合
        $response = $this->json('GET', "/api/folders/search?q");
        $response->assertStatus(422);
    }
}

