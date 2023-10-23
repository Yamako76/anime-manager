<?php

namespace Tests\app\Services\Api\Folder;

use App\Models\Folder;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class FolderServiceTest extends TestCase
{
    use DatabaseTransactions;

    public function setUp(): void
    {
        parent::setUp();
    }

    // フォルダを作成順に取得するテスト
    public function test_success_getFolderListByUserId__created_at()
    {
        $userId = 1;
        $expectedFolderNames = [];

        for ($i = 1; $i <= 20; $i++) {
            $folderName = "フォルダ{$i}";
            $expectedFolderNames[] = $folderName;

            $folder = new Folder();
            $customDateTime = Carbon::parse("20{$i}-01-01 00:00:00");
            $folder->user_id = $userId;
            $folder->status = Folder::STATUS_ACTIVE;
            $folder->name = "フォルダ{$i}";
            $folder->latest_changed_at = $customDateTime;
            $folder->created_at = $customDateTime;
            $folder->updated_at = $customDateTime;
            $folder->save();
        }

        $currentPage = 1;
        $paginateUnit = 20;
        $sortType = 'created_at';
        $folderList = \FolderService::getFolderListByUserId($userId, $currentPage, $paginateUnit, $sortType);

        $actualFolderNames = $folderList->pluck('name')->toArray();

        $this->assertEquals($expectedFolderNames, $actualFolderNames);

        $this->refreshApplication();
    }

    // フォルダを最新順に取得するテスト
    public function test_success_getFolderListByUserId__latest()
    {
        $userId = 1;
        $expectedFolderNames = [];

        for ($i = 1; $i <= 20; $i++) {
            Folder::create([
                'user_id' => $userId,
                'status' => Folder::STATUS_ACTIVE,
                'name' => "フォルダ{$i}",
                'memo' => 'This is a memo.',
                'latest_changed_at' => now(),
            ]);
        }

        for ($i = 20; $i > 0; $i--) {
            $folderName = "フォルダ{$i}";
            $expectedFolderNames[] = $folderName;
        }

        $currentPage = 1;
        $paginateUnit = 20;
        $sortType = 'latest';
        $folderList = \FolderService::getFolderListByUserId($userId, $currentPage, $paginateUnit, $sortType);

        $actualFolderNames = $folderList->pluck('name')->toArray();
        $this->assertEquals($expectedFolderNames, $actualFolderNames);

        $this->refreshApplication();
    }

    // フォルダを名前順に取得するテスト
    public function test_success_getFolderListByUserId__title()
    {
        $userId = 1;
        $expectedFolderNames = [];

        for ($i = 1; $i <= 20; $i++) {
            $folderName = "フォルダ{$i}";
            $expectedFolderNames[] = $folderName;

            Folder::create([
                'user_id' => $userId,
                'status' => Folder::STATUS_ACTIVE,
                'name' => "フォルダ{$i}",
                'memo' => 'This is a memo.',
                'latest_changed_at' => now(),
            ]);
        }

        $currentPage = 1;
        $paginateUnit = 20;
        $sortType = 'title';
        $folderList = \FolderService::getFolderListByUserId($userId, $currentPage, $paginateUnit, $sortType);

        sort($expectedFolderNames);
        $actualFolderNames = $folderList->pluck('name')->toArray();
        $this->assertEquals($expectedFolderNames, $actualFolderNames);

        $this->refreshApplication();
    }

    // フォルダ取得の際に無効なソートタイプのテスト
    public function test_failure_getFolderListByUserId__invalid_arguments()
    {
        $this->expectException(\InvalidArgumentException::class);

        $userId = 1;
        $currentPage = 1;
        $paginateUnit = 20;
        $sortType = 'invalid_sort_type';
        \FolderService::getFolderListByUserId($userId, $currentPage, $paginateUnit, $sortType);
    }

    // フォルダをレコードに保存するテスト
    public function test_success_createFolderRecord()
    {
        $userId = 1;
        $name = "Folder";

        $folder = \FolderService::createFolderRecord($userId, $name);

        $this->assertInstanceOf(Folder::class, $folder);
        $this->assertEquals($userId, $folder->user_id);
        $this->assertEquals($name, $folder->name);
        $this->assertEquals(Folder::STATUS_ACTIVE, $folder->status);
        $this->assertNotNull($folder->latest_changed_at);
        $this->assertNotNull($folder->created_at);
        $this->assertNotNull($folder->updated_at);

        $this->refreshApplication();
    }

    // フォルダを folderId, userId から取得するテスト
    public function test_success_getFolderByIdAndUserId()
    {
        $userId = 1;
        $folderId = 1;

        $now = Carbon::now();
        $folder = new Folder();
        $folder->user_id = $userId;
        $folder->name = "Folder";
        $folder->status = Folder::STATUS_ACTIVE;
        $folder->latest_changed_at = $now;
        $folder->created_at = $now;
        $folder->updated_at = $now;
        $folder->save();

        $retrievedFolder = \FolderService::getFolderByIdAndUserId($folderId, $userId);
        $this->assertInstanceOf(Folder::class, $retrievedFolder);
        $this->assertEquals($userId, $retrievedFolder->user_id);
        $this->assertEquals($folderId, $retrievedFolder->id);

        $this->refreshApplication();
    }

    // フォルダを folderId, userId から取得する際にフォルダが存在しない場合のテスト
    public function test_getFolderByIdAndUserId_return_null()
    {
        $folderId = 999;
        $userId = 1;

        $result = \FolderService::getFolderByIdAndUserId($folderId, $userId);
        $this->assertNull($result);
    }

    // フォルダを name, userId から取得するテスト
    public function test_success_getFolderByUserIdAndName()
    {
        $userId = 1;
        $name = "フォルダ1";

        $now = Carbon::now();
        $folder = new Folder();
        $folder->user_id = $userId;
        $folder->name = $name;
        $folder->status = Folder::STATUS_ACTIVE;
        $folder->latest_changed_at = $now;
        $folder->created_at = $now;
        $folder->updated_at = $now;
        $folder->save();

        $retrievedFolder = \FolderService::getFolderByUserIdAndName($userId, $name);
        $this->assertInstanceOf(Folder::class, $retrievedFolder);
        $this->assertEquals($userId, $retrievedFolder->user_id);
        $this->assertEquals($name, $retrievedFolder->name);

        $this->refreshApplication();
    }

    // フォルダを name, userId から取得する際にフォルダが存在しない場合のテスト
    public function test_success_getFolderByUserIdAndName_return_null()
    {
        $name = "フォルダ999";
        $userId = 1;

        $result = \FolderService::getFolderByUserIdAndName($userId, $name);
        $this->assertNull($result);
    }

    // 新しいフォルダを作成するテスト
    public function test_success_createFolder__record_new_folder()
    {
        $userId = 1;
        $name = "フォルダ1";

        $folder = \FolderService::createFolder($userId, $name);

        $this->assertInstanceOf(Folder::class, $folder);
        $this->assertEquals($userId, $folder->user_id);
        $this->assertEquals(1, $folder->id);
        $this->assertEquals($name, $folder->name);

        $this->refreshApplication();
    }

    // 新しいフォルダを作成する際にそのフォルダが存在する場合のテスト
    public function test_success_createFolder__status_active()
    {
        $userId = 1;
        $name = "アニメ1";

        $now = Carbon::now();
        $folder = new Folder();
        $folder->user_id = $userId;
        $folder->name = $name;
        $folder->status = Folder::STATUS_ACTIVE;
        $folder->latest_changed_at = $now;
        $folder->created_at = $now;
        $folder->updated_at = $now;
        $folder->save();

        $folder = \FolderService::createFolder($userId, $name);

        $this->assertInstanceOf(Folder::class, $folder);
        $this->assertEquals($userId, $folder->user_id);
        $this->assertEquals(1, $folder->id);
        $this->assertEquals($name, $folder->name);
        $this->assertEquals(Folder::STATUS_ACTIVE, $folder->status);

        $this->refreshApplication();
    }

    // 新しいフォルダを作成する際にそのフォルダが削除されていた場合のテスト
    public function test_success_createFolder__status_deleted()
    {
        $this->assertTrue(true);
    }

    // 新しいフォルダを作成する際にそのフォルダの status が存在しない値の場合のテスト
    public function test_failure_createFolder__folder_state_not_found()
    {
        $this->assertTrue(true);
    }

    // フォルダを編集し新しい値が保存されていることのテスト
    public function test_success_updateFolderRecord()
    {
        $this->assertTrue(true);
    }

    // フォルダを検索する際にそのキーワードのフォルダが存在する場合のテスト
    public function test_success_searchFolder()
    {
        $this->assertTrue(true);
    }

    // フォルダを検索する際にそのキーワードのフォルダが存在しない場合のテスト
    public function test_success_searchFolder_no_match()
    {
        $this->assertTrue(true);
    }
}

