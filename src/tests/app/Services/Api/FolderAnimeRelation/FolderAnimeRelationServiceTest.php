<?php

namespace Tests\app\Services\Api\FolderAnimeRelation;

use App\Models\Anime;
use App\Models\Folder;
use App\Models\FolderAnimeRelation;
use App\Services\Api\FolderAnimeRelation\State\FolderAnimeRelationStateNotFoundException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class FolderAnimeRelationServiceTest extends TestCase
{
    use DatabaseTransactions;

    public function setUp(): void
    {
        parent::setUp();
    }

    // あるフォルダに所属するアニメを作成順に取得するテスト
    public function test_success_getAnimeListByUserIdAndFolderId__created_at()
    {
        $userId = 1;
        $folderId = 1;

        $expectedAnimeNames = [];
        for ($i = 1; $i <= 20; $i++) {
            $animeName = "アニメ{$i}";

            $customDateTime = Carbon::parse("20{$i}-01-01 00:00:00");
            $anime = new Anime();
            $anime->user_id = $userId;
            $anime->status = Anime::STATUS_ACTIVE;
            $anime->name = $animeName;
            $anime->memo = 'This is a memo.';
            $anime->latest_changed_at = $customDateTime;
            $anime->created_at = $customDateTime;
            $anime->updated_at = $customDateTime;
            $anime->save();

            if ($i % 2 == 1) {
                $expectedAnimeNames[] = $animeName;
                $folderAnimeRelation = new FolderAnimeRelation();
                $folderAnimeRelation->user_id = $userId;
                $folderAnimeRelation->folder_id = $folderId;
                $folderAnimeRelation->anime_id = $anime->id;
                $folderAnimeRelation->status = FolderAnimeRelation::STATUS_ACTIVE;
                $folderAnimeRelation->latest_changed_at = $customDateTime;
                $folderAnimeRelation->created_at = $customDateTime;
                $folderAnimeRelation->save();
            }
        }

        $currentPage = 1;
        $paginateUnit = 20;
        $sortType = 'created_at';
        $animeList = \FolderAnimeRelationService::getAnimeListByUserIdAndFolderId($userId, $folderId, $currentPage, $paginateUnit, $sortType);

        $actualAnimeNames = $animeList->pluck('name')->toArray();
        $this->assertEquals($expectedAnimeNames, $actualAnimeNames);

        $this->refreshApplication();
    }

    // あるフォルダに所属するアニメを最新順に取得するテスト
    public function test_success_getAnimeListByUserIdAndFolderId__latest()
    {
        $userId = 1;
        $folderId = 1;

        $expectedAnimeNames = [];
        for ($i = 1; $i <= 20; $i++) {
            $animeName = "アニメ{$i}";

            $anime = new Anime();
            $anime->user_id = $userId;
            $anime->status = Anime::STATUS_ACTIVE;
            $anime->name = $animeName;
            $anime->memo = 'memo';
            $anime->latest_changed_at = now();
            $anime->created_at = now();
            $anime->updated_at = now();
            $anime->save();

            if ($i % 2 == 1) {
                $folderAnimeRelation = new FolderAnimeRelation();
                $folderAnimeRelation->user_id = $userId;
                $folderAnimeRelation->folder_id = $folderId;
                $folderAnimeRelation->anime_id = $anime->id;
                $folderAnimeRelation->status = FolderAnimeRelation::STATUS_ACTIVE;
                $folderAnimeRelation->latest_changed_at = now();
                $folderAnimeRelation->created_at = now();
                $folderAnimeRelation->save();
            }
        }
        for ($i = 20; $i > 0; $i--) {
            if ($i % 2 == 1) {
                $animeName = "アニメ{$i}";
                $expectedAnimeNames[] = $animeName;
            }
        }

        $currentPage = 1;
        $paginateUnit = 20;
        $sortType = 'latest';
        $animeList = \FolderAnimeRelationService::getAnimeListByUserIdAndFolderId($userId, $folderId, $currentPage, $paginateUnit, $sortType);

        $actualAnimeNames = $animeList->pluck('name')->toArray();
        $this->assertEquals($expectedAnimeNames, $actualAnimeNames);

        $this->refreshApplication();
    }

    // あるフォルダに所属するアニメを名前順に取得するテスト
    public function test_success_getAnimeListByUserIdAndFolderId__title()
    {
        $userId = 1;
        $folderId = 1;

        $expectedAnimeNames = [];
        for ($i = 1; $i <= 20; $i++) {
            $animeName = "アニメ{$i}";

            $anime = new Anime();
            $anime->user_id = $userId;
            $anime->status = Anime::STATUS_ACTIVE;
            $anime->name = $animeName;
            $anime->memo = 'memo';
            $anime->latest_changed_at = now();
            $anime->created_at = now();
            $anime->updated_at = now();
            $anime->save();

            if ($i % 2 == 1) {
                $expectedAnimeNames[] = $animeName;
                $folderAnimeRelation = new FolderAnimeRelation();
                $folderAnimeRelation->user_id = $userId;
                $folderAnimeRelation->folder_id = $folderId;
                $folderAnimeRelation->anime_id = $anime->id;
                $folderAnimeRelation->status = FolderAnimeRelation::STATUS_ACTIVE;
                $folderAnimeRelation->latest_changed_at = now();
                $folderAnimeRelation->created_at = now();
                $folderAnimeRelation->save();
            }
        }

        $currentPage = 1;
        $paginateUnit = 20;
        $sortType = 'title';
        $animeList = \FolderAnimeRelationService::getAnimeListByUserIdAndFolderId($userId, $folderId, $currentPage, $paginateUnit, $sortType);

        sort($expectedAnimeNames);
        $actualAnimeNames = $animeList->pluck('name')->toArray();
        $this->assertEquals($expectedAnimeNames, $actualAnimeNames);

        $this->refreshApplication();
    }

    // あるフォルダに所属するアニメ取得の際に無効なソートタイプのテスト
    public function test_failure_getAnimeListByUserIdAndFolderId__invalid_arguments()
    {
        $this->expectException(\InvalidArgumentException::class);

        $userId = 1;
        $folderId = 1;
        $currentPage = 1;
        $paginateUnit = 20;
        $sortType = 'invalid_sort_type';
        \FolderAnimeRelationService::getAnimeListByUserIdAndFolderId($userId, $folderId, $currentPage, $paginateUnit, $sortType);

    }

    // userId と folderName からフォルダを取得するテスト
    public function test_success_getFolderByUserIdAndFolderName()
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

        $retrievedFolder = \FolderAnimeRelationService::getFolderByUserIdAndFolderName($userId, $name);
        $this->assertInstanceOf(Folder::class, $retrievedFolder);
        $this->assertEquals($userId, $retrievedFolder->user_id);
        $this->assertEquals($name, $retrievedFolder->name);

        $this->refreshApplication();
    }

    // userId と folderName からフォルダ際にフォルダが存在しない場合のテスト
    public function test_getFolderByUserIdAndFolderName_return_null()
    {
        $name = "フォルダ999";
        $userId = 1;

        $result = \FolderAnimeRelationService::getFolderByUserIdAndFolderName($userId, $name);
        $this->assertNull($result);
    }

    // userId と animeName からアニメを取得するテスト
    public function test_success_getAnimeByUserIdAndAnimeName()
    {
        $userId = 1;
        $name = "アニメ1";

        $now = Carbon::now();
        $anime = new Anime();
        $anime->user_id = $userId;
        $anime->name = $name;
        $anime->memo = "test";
        $anime->status = Anime::STATUS_ACTIVE;
        $anime->latest_changed_at = $now;
        $anime->created_at = $now;
        $anime->updated_at = $now;
        $anime->save();

        $retrievedAnime = \FolderAnimeRelationService::getAnimeByUserIdAndAnimeName($userId, $name);
        $this->assertInstanceOf(Anime::class, $retrievedAnime);
        $this->assertEquals($userId, $retrievedAnime->user_id);
        $this->assertEquals($name, $retrievedAnime->name);

        $this->refreshApplication();
    }

    // userId と animeName からアニメを取得する際にアニメが存在しない場合のテスト
    public function test_success_getAnimeByUserIdAndAnimeName_return_null()
    {
        $name = "アニメ999";
        $userId = 1;

        $result = \FolderAnimeRelationService::getAnimeByUserIdAndAnimeName($userId, $name);
        $this->assertNull($result);
    }

    // // userId と folderId ,animeId からアニメを取得するテスト
    public function test_success_getFolderAnimeRelationByUserIdAndFolderIdAndAnimeId()
    {
        $userId = 1;
        $folderId = 1;
        $animeId = 1;
        $folderAnimeRelation = new FolderAnimeRelation();
        $folderAnimeRelation->user_id = $userId;
        $folderAnimeRelation->folder_id = $folderId;
        $folderAnimeRelation->anime_id = $animeId;
        $folderAnimeRelation->status = FolderAnimeRelation::STATUS_ACTIVE;
        $folderAnimeRelation->latest_changed_at = now();
        $folderAnimeRelation->created_at = now();
        $folderAnimeRelation->save();

        $retrievedRelation = \FolderAnimeRelationService::getFolderAnimeRelationByUserIdAndFolderIdAndAnimeId($userId, $folderId, $animeId);

        $this->assertInstanceOf(FolderAnimeRelation::class, $retrievedRelation);
        $this->assertEquals($userId, $retrievedRelation->user_id);
        $this->assertEquals($folderId, $retrievedRelation->folder_id);
        $this->assertEquals($animeId, $retrievedRelation->anime_id);

        $this->refreshApplication();
    }

    // userId と folderId ,animeId からアニメを取得する際にアニメが存在しない場合のテスト
    public function test_success_getFolderAnimeRelationByUserIdAndFolderIdAndAnimeId_return_null()
    {
        $userId = 999;
        $folderId = 999;
        $animeId = 999;

        $result = \FolderAnimeRelationService::getFolderAnimeRelationByUserIdAndFolderIdAndAnimeId($userId, $folderId, $animeId);
        $this->assertNull($result);
    }

    // フォルダに属するアニメをレコードに保存するテスト
    public function test_success_createFolderAnimeRelationRecord()
    {
        $userId = 1;
        $folderId = 1;
        $animeId = 1;

        $folderAnimeRelation = \FolderAnimeRelationService::createFolderAnimeRelation($userId, $folderId, $animeId);

        $this->assertInstanceOf(FolderAnimeRelation::class, $folderAnimeRelation);
        $this->assertEquals($userId, $folderAnimeRelation->user_id);
        $this->assertEquals($folderId, $folderAnimeRelation->folder_id);
        $this->assertEquals($animeId, $folderAnimeRelation->anime_id);
        $this->assertEquals(FolderAnimeRelation::STATUS_ACTIVE, $folderAnimeRelation->status);
        $this->assertNotNull($folderAnimeRelation->latest_changed_at);
        $this->assertNotNull($folderAnimeRelation->created_at);
        $this->assertNotNull($folderAnimeRelation->updated_at);

        $this->refreshApplication();
    }

    // フォルダに新しいアニメを追加するテスト
    public function test_success_createFolderAnimeRelation__record_new_anime()
    {
        $userId = 1;
        $folderId = 1;
        $animeId = 1;

        $folderAnimeRelation = \FolderAnimeRelationService::createFolderAnimeRelation($userId, $folderId, $animeId);

        $this->assertInstanceOf(FolderAnimeRelation::class, $folderAnimeRelation);
        $this->assertEquals($userId, $folderAnimeRelation->user_id);
        $this->assertEquals(1, $folderAnimeRelation->id);
        $this->assertEquals($folderId, $folderAnimeRelation->folder_id);
        $this->assertEquals($animeId, $folderAnimeRelation->anime_id);

        $this->refreshApplication();
    }

    // フォルダに新しいアニメを追加する際にそのアニメが存在する場合のテスト
    public function test_success_createFolderAnimeRelation__status_active()
    {
        $userId = 1;
        $folderId = 1;
        $animeId = 1;

        $now = Carbon::now();
        $folderAnimeRelation = new FolderAnimeRelation();
        $folderAnimeRelation->user_id = $userId;
        $folderAnimeRelation->folder_id = $folderId;
        $folderAnimeRelation->anime_id = $animeId;
        $folderAnimeRelation->status = FolderAnimeRelation::STATUS_ACTIVE;
        $folderAnimeRelation->latest_changed_at = $now;
        $folderAnimeRelation->created_at = $now;
        $folderAnimeRelation->save();

        $folderAnimeRelation = \FolderAnimeRelationService::createFolderAnimeRelation($userId, $folderId, $animeId);

        $this->assertInstanceOf(FolderAnimeRelation::class, $folderAnimeRelation);
        $this->assertEquals($userId, $folderAnimeRelation->user_id);
        $this->assertEquals(1, $folderAnimeRelation->id);
        $this->assertEquals($folderId, $folderAnimeRelation->folder_id);
        $this->assertEquals($animeId, $folderAnimeRelation->anime_id);
        $this->assertEquals(FolderAnimeRelation::STATUS_ACTIVE, $folderAnimeRelation->status);

        $this->refreshApplication();
    }

    // フォルダに新しいアニメを作成する際にそのアニメが削除されていた場合のテスト
    public function test_success_createFolderAnimeRelation__status_deleted()
    {
        $userId = 1;
        $folderId = 1;
        $animeId = 1;

        $now = Carbon::now();
        $folderAnimeRelation = new FolderAnimeRelation();
        $folderAnimeRelation->user_id = $userId;
        $folderAnimeRelation->folder_id = $folderId;
        $folderAnimeRelation->anime_id = $animeId;
        $folderAnimeRelation->status = FolderAnimeRelation::STATUS_DELETED;
        $folderAnimeRelation->latest_changed_at = $now;
        $folderAnimeRelation->created_at = $now;
        $folderAnimeRelation->save();

        $folderAnimeRelation = \FolderAnimeRelationService::createFolderAnimeRelation($userId, $folderId, $animeId);

        $this->assertInstanceOf(FolderAnimeRelation::class, $folderAnimeRelation);
        $this->assertEquals($userId, $folderAnimeRelation->user_id);
        $this->assertEquals(1, $folderAnimeRelation->id);
        $this->assertEquals($folderId, $folderAnimeRelation->folder_id);
        $this->assertEquals($animeId, $folderAnimeRelation->anime_id);
        $this->assertEquals(FolderAnimeRelation::STATUS_ACTIVE, $folderAnimeRelation->status);

        $this->refreshApplication();
    }

    // フォルダに新しいアニメを作成する際にそのアニメの status が存在しない値の場合のテスト
    public function test_failure_createFolderAnimeRelation__anime_state_not_found()
    {
        $userId = 1;
        $folderId = 1;
        $animeId = 1;

        $now = Carbon::now();
        $folderAnimeRelation = new FolderAnimeRelation();
        $folderAnimeRelation->user_id = $userId;
        $folderAnimeRelation->folder_id = $folderId;
        $folderAnimeRelation->anime_id = $animeId;
        $folderAnimeRelation->status = "anime";
        $folderAnimeRelation->latest_changed_at = $now;
        $folderAnimeRelation->created_at = $now;
        $folderAnimeRelation->save();

        $this->expectException(FolderAnimeRelationStateNotFoundException::class);

        \FolderAnimeRelationService::createFolderAnimeRelation($userId, $folderId, $animeId);

        $this->refreshApplication();
    }


    // フォルダ内でアニメを検索する際にそのキーワードのアニメが存在する場合のテスト
    public function test_success_searchFolderAnime()
    {
        $userId = 1;
        $folderId = 1;
        $keyWord = "1";

        $anime1 = new Anime();
        $anime1->user_id = 1;
        $anime1->name = "アニメ1";
        $anime1->memo = "メモ1";
        $anime1->status = Anime::STATUS_ACTIVE;
        $anime1->latest_changed_at = now();
        $anime1->created_at = now();
        $anime1->updated_at = now();
        $anime1->save();

        $anime2 = new Anime();
        $anime2->user_id = 1;
        $anime2->name = "アニメ2";
        $anime2->memo = "メモ2";
        $anime2->status = Anime::STATUS_ACTIVE;
        $anime2->latest_changed_at = now();
        $anime2->created_at = now();
        $anime2->updated_at = now();
        $anime2->save();

        $folderAnimeRelation1 = new FolderAnimeRelation();
        $folderAnimeRelation1->user_id = $userId;
        $folderAnimeRelation1->folder_id = $folderId;
        $folderAnimeRelation1->anime_id = $anime1->id;
        $folderAnimeRelation1->status = FolderAnimeRelation::STATUS_ACTIVE;
        $folderAnimeRelation1->latest_changed_at = now();
        $folderAnimeRelation1->created_at = now();
        $folderAnimeRelation1->save();

        $folderAnimeRelation2 = new FolderAnimeRelation();
        $folderAnimeRelation2->user_id = $userId;
        $folderAnimeRelation2->folder_id = $folderId;
        $folderAnimeRelation2->anime_id = $anime2->id;
        $folderAnimeRelation2->status = FolderAnimeRelation::STATUS_ACTIVE;
        $folderAnimeRelation2->latest_changed_at = now();
        $folderAnimeRelation2->created_at = now();
        $folderAnimeRelation2->save();


        $animeList = \FolderAnimeRelationService::searchFolderAnime($userId, $folderId, $keyWord);

        $this->assertCount(1, $animeList);
        $this->assertEquals($anime1->name, $animeList[0]->name);

        $this->refreshApplication();
    }

    // フォルダ内でアニメを検索する際にそのキーワードのアニメが存在しない場合のテスト
    public function test_success_searchFolderAnime_no_match()
    {
        $userId = 1;
        $folderId = 1;
        $keyWord = "anime";

        $anime = new Anime();
        $anime->user_id = 1;
        $anime->name = "アニメ1";
        $anime->memo = "メモ1";
        $anime->status = Anime::STATUS_ACTIVE;
        $anime->latest_changed_at = now();
        $anime->created_at = now();
        $anime->updated_at = now();
        $anime->save();

        $folderAnimeRelation = new FolderAnimeRelation();
        $folderAnimeRelation->user_id = $userId;
        $folderAnimeRelation->folder_id = $folderId;
        $folderAnimeRelation->anime_id = $anime->id;
        $folderAnimeRelation->status = FolderAnimeRelation::STATUS_ACTIVE;
        $folderAnimeRelation->latest_changed_at = now();
        $folderAnimeRelation->created_at = now();
        $folderAnimeRelation->save();

        $animeList = \FolderAnimeRelationService::searchFolderAnime($userId, $folderId, $keyWord);

        $this->assertInstanceOf(\Illuminate\Support\Collection::class, $animeList);
        $this->assertCount(0, $animeList);

        $this->refreshApplication();
    }
}

