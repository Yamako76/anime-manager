<?php

namespace Tests\app\Http\Controllers\Api\Folder\Create;

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

    public function test_success_create_folder()
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

        \FolderService::shouldReceive('createFolder')
            ->andReturn($folder)
            ->once();

        $response = $this->json('POST', '/api/folders', ['name' => 'フォルダ']);
        $response->assertStatus(200);
    }

    public function test_error_create_folder()
    {
        // nameがない場合
        $response = $this->json('POST', '/api/folders', []);
        $response->assertStatus(422);

        // name = ""の場合
        $response = $this->json('POST', '/api/folders', ['name' => ""]);
        $response->assertStatus(422);

        // nameが200文字を超える場合
        $str = 'abcdefghijklmnopqrstuvwxyz0123456789';
        $name = substr(str_shuffle(str_repeat($str, 10)), 0, 201);
        $response = $this->json('POST', '/api/folders', ['name' => $name]);
        $response->assertStatus(422);
    }
}

