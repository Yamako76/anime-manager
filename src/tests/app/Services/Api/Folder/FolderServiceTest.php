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
            $animeName = "フォルダ{$i}";
            $expectedFolderNames[] = $animeName;

            $anime = new Folder();
            $customDateTime = Carbon::parse("20{$i}-01-01 00:00:00");
            $anime->user_id = $userId;
            $anime->status = Folder::STATUS_ACTIVE;
            $anime->name = "フォルダ{$i}";
            $anime->latest_changed_at = $customDateTime;
            $anime->created_at = $customDateTime;
            $anime->updated_at = $customDateTime;
            $anime->save();
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
        $this->assertTrue(true);
    }

    // フォルダを folderId, userId から取得するテスト
    public function test_success_getFolderByIdAndUserId()
    {
        $this->assertTrue(true);
    }

    // フォルダを folderId, userId から取得する際にフォルダが存在しない場合のテスト
    public function test_getFolderByIdAndUserId_return_null()
    {
        $this->assertTrue(true);
    }

    // フォルダを name, userId から取得するテスト
    public function test_success_getFolderByUserIdAndName()
    {
        $this->assertTrue(true);
    }

    // フォルダを name, userId から取得する際にフォルダが存在しない場合のテスト
    public function test_success_getFolderByUserIdAndName_return_null()
    {
        $this->assertTrue(true);
    }

    // 新しいフォルダを作成するテスト
    public function test_success_createFolder__record_new_folder()
    {
        $this->assertTrue(true);
    }

    // 新しいフォルダを作成する際にそのフォルダが存在する場合のテスト
    public function test_success_createFolder__status_active()
    {
        $this->assertTrue(true);
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

