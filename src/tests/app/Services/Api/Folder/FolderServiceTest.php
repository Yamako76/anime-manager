<?php

namespace Tests\app\Services\Api\Folder;

use App\Models\Folder;
use App\Services\Api\Folder\State\FolderStateNotFoundException;
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

        $folder1 = $this->createFolder($userId, "フォルダ1", Folder::STATUS_ACTIVE, Carbon::now(), Carbon::now(), Carbon::now());
        $folder2 = $this->createFolder($userId, "フォルダ2", Folder::STATUS_ACTIVE, Carbon::now(), Carbon::now(), Carbon::now());
        $folder3 = $this->createFolder($userId, "フォルダ3", Folder::STATUS_ACTIVE, Carbon::now(), Carbon::now(), Carbon::now());

        $currentPage = 1;
        $paginateUnit = 20;
        $sortType = 'created_at';
        $folderList = \FolderService::getFolderListByUserId($userId, $currentPage, $paginateUnit, $sortType);

        $actualFolderNames = $folderList->pluck('name')->toArray();

        $this->assertEquals($folder1->name, $actualFolderNames[0]);
        $this->assertEquals($folder2->name, $actualFolderNames[1]);
        $this->assertEquals($folder3->name, $actualFolderNames[2]);
    }

    // フォルダを最新順に取得するテスト
    public function test_success_getFolderListByUserId__latest()
    {
        $userId = 1;

        $folder1 = $this->createFolder($userId, "フォルダ1", Folder::STATUS_ACTIVE, Carbon::now(), Carbon::now(), Carbon::now());
        $folder2 = $this->createFolder($userId, "フォルダ2", Folder::STATUS_ACTIVE, Carbon::now(), Carbon::now(), Carbon::now());
        $folder3 = $this->createFolder($userId, "フォルダ3", Folder::STATUS_ACTIVE, Carbon::now(), Carbon::now(), Carbon::now());

        $currentPage = 1;
        $paginateUnit = 20;
        $sortType = 'latest';
        $folderList = \FolderService::getFolderListByUserId($userId, $currentPage, $paginateUnit, $sortType);

        $actualFolderNames = $folderList->pluck('name')->toArray();
        $this->assertEquals($folder1->name, $actualFolderNames[2]);
        $this->assertEquals($folder2->name, $actualFolderNames[1]);
        $this->assertEquals($folder3->name, $actualFolderNames[0]);
    }

    // フォルダを名前順に取得するテスト
    public function test_success_getFolderListByUserId__title()
    {
        $userId = 1;

        $folder1 = $this->createFolder($userId, "フォルダ1", Folder::STATUS_ACTIVE, Carbon::now(), Carbon::now(), Carbon::now());
        $folder2 = $this->createFolder($userId, "フォルダ3", Folder::STATUS_ACTIVE, Carbon::now(), Carbon::now(), Carbon::now());
        $folder3 = $this->createFolder($userId, "フォルダ2", Folder::STATUS_ACTIVE, Carbon::now(), Carbon::now(), Carbon::now());

        $currentPage = 1;
        $paginateUnit = 20;
        $sortType = 'title';
        $folderList = \FolderService::getFolderListByUserId($userId, $currentPage, $paginateUnit, $sortType);

        $actualFolderNames = $folderList->pluck('name')->toArray();
        $this->assertEquals($folder1->name, $actualFolderNames[0]);
        $this->assertEquals($folder3->name, $actualFolderNames[1]);
        $this->assertEquals($folder2->name, $actualFolderNames[2]);
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
    }

    // フォルダを folderId, userId から取得するテスト
    public function test_success_getFolderByIdAndUserId()
    {
        $userId = 1;
        $folderId = 1;

        $now = Carbon::now();
        $folder = $this->createFolder($userId, "フォルダ1", Folder::STATUS_ACTIVE, $now, $now, $now);

        $retrievedFolder = \FolderService::getFolderByIdAndUserId($folderId, $userId);
        $this->assertInstanceOf(Folder::class, $retrievedFolder);
        $this->assertEquals($folder->user_id, $retrievedFolder->user_id);
        $this->assertEquals($folder->id, $retrievedFolder->id);
    }

    // フォルダを name, userId から取得するテスト
    public function test_success_getFolderByUserIdAndName()
    {
        $userId = 1;
        $name = "フォルダ1";

        $now = Carbon::now();
        $folder = $this->createFolder($userId, "フォルダ1", Folder::STATUS_ACTIVE, $now, $now, $now);

        $retrievedFolder = \FolderService::getFolderByUserIdAndName($userId, $name);
        $this->assertInstanceOf(Folder::class, $retrievedFolder);
        $this->assertEquals($folder->user_id, $retrievedFolder->user_id);
        $this->assertEquals($folder->name, $retrievedFolder->name);
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
    }

    // 新しいフォルダを作成する際にそのフォルダが存在する場合のテスト
    public function test_success_createFolder__status_active()
    {
        $userId = 1;
        $name = "フォルダ1";

        $now = Carbon::now();
        $expectedFolder = $this->createFolder($userId, $name, Folder::STATUS_ACTIVE, $now, $now, $now);

        $folder = \FolderService::createFolder($userId, $name);
        $count = Folder::count();

        $this->assertInstanceOf(Folder::class, $folder);
        $this->assertEquals($expectedFolder->user_id, $folder->user_id);
        $this->assertEquals($expectedFolder->id, $folder->id);
        $this->assertEquals($expectedFolder->name, $folder->name);
        $this->assertEquals($expectedFolder->status, $folder->status);
        $this->assertEquals(1, $count);
    }

    // 新しいフォルダを作成する際にそのフォルダが削除されていた場合のテスト
    public function test_success_createFolder__status_deleted()
    {
        $userId = 1;
        $name = "フォルダ1";

        $now = Carbon::now();
        $expectedFolder = $this->createFolder($userId, $name, Folder::STATUS_DELETED, $now, $now, $now);

        $folder = \FolderService::createFolder($userId, $name);
        $count = Folder::count();

        $this->assertInstanceOf(Folder::class, $folder);
        $this->assertEquals($expectedFolder->user_id, $folder->user_id);
        $this->assertEquals($expectedFolder->id, $folder->id);
        $this->assertEquals($expectedFolder->name, $folder->name);
        $this->assertEquals(Folder::STATUS_ACTIVE, $folder->status);
        $this->assertEquals(1, $count);
    }

    // 新しいフォルダを作成する際にそのフォルダの status が存在しない値の場合のテスト
    public function test_failure_createFolder__folder_state_not_found()
    {
        $userId = 1;
        $name = "フォルダ1";

        $now = Carbon::now();
        $folder = $this->createFolder($userId, $name, "folder", $now, $now, $now);

        $this->expectException(FolderStateNotFoundException::class);

        \FolderService::createFolder($userId, $name);
    }

    // フォルダを編集し新しい値が保存されていることのテスト
    public function test_success_updateFolderRecord()
    {
        $userId = 1;
        $name = "フォルダ1";

        $yesterday = Carbon::now()->subDay();

        $folder = $this->createFolder($userId, $name, Folder::STATUS_ACTIVE, $yesterday, $yesterday, $yesterday);

        $newName = "Folder";

        $updatedFolder = \FolderService::updateFolderRecord($folder, $newName);

        $this->assertInstanceOf(Folder::class, $updatedFolder);
        $this->assertEquals($newName, $updatedFolder->name);
    }

    // フォルダを検索する際にそのキーワードのフォルダが存在する場合のテスト
    public function test_success_searchFolder()
    {
        $userId = 1;

        $now = Carbon::now();
        // 1が半角の場合
        $folder1 = $this->createFolder($userId, "フォルダ1", Folder::STATUS_ACTIVE, $now, $now, $now);
        // １が全角場合
        $folder2 = $this->createFolder($userId, "フォルダ１", Folder::STATUS_ACTIVE, $now, $now, $now);
        $folder3 = $this->createFolder($userId, "フォルダa", Folder::STATUS_ACTIVE, $now, $now, $now);
        $folder4 = $this->createFolder($userId, "フォルダA", Folder::STATUS_ACTIVE, $now, $now, $now);

        // 半角と全角の違いを確認するテスト
        $folderList1 = \FolderService::searchFolder($userId, "1");
        $this->assertCount(1, $folderList1);
        $this->assertEquals($folder1->name, $folderList1[0]->name);

        // 大文字と小文字の区別はされないことを確認するテスト
        $folderList2 = \FolderService::searchFolder($userId, "A");
        $this->assertCount(2, $folderList2);
        $this->assertEquals($folder4->name, $folderList2[0]->name);
    }

    // フォルダをレコードに保存する関数。
    private function createFolder(int $userId, string $name, string $status, string $latest_changed_at, string $created_at, string $updated_at)
    {
        $folder = new Folder();
        $folder->user_id = $userId;
        $folder->name = $name;
        $folder->status = $status;
        $folder->latest_changed_at = $latest_changed_at;
        $folder->created_at = $created_at;
        $folder->updated_at = $updated_at;
        $folder->save();

        return $folder;
    }
}

