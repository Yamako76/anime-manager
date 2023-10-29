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

        $anime1 = $this->createAnime($userId, "アニメ1", "メモ", Anime::STATUS_ACTIVE, Carbon::now(), Carbon::now(), Carbon::now());
        $anime2 = $this->createAnime($userId, "アニメ2", "メモ", Anime::STATUS_ACTIVE, Carbon::now(), Carbon::now(), Carbon::now());
        $anime3 = $this->createAnime($userId, "アニメ3", "メモ", Anime::STATUS_ACTIVE, Carbon::now(), Carbon::now(), Carbon::now());

        $folderAnime1 = $this->createFolderAnime($userId, $folderId, $anime1->id, Anime::STATUS_ACTIVE, Carbon::now(), Carbon::now(), Carbon::now());
        $folderAnime2 = $this->createFolderAnime($userId, $folderId, $anime2->id, Anime::STATUS_ACTIVE, Carbon::now(), Carbon::now(), Carbon::now());
        $folderAnime3 = $this->createFolderAnime($userId, $folderId, $anime3->id, Anime::STATUS_ACTIVE, Carbon::now(), Carbon::now(), Carbon::now());

        $currentPage = 1;
        $paginateUnit = 20;
        $sortType = 'created_at';
        $animeList = \FolderAnimeRelationService::getAnimeListByUserIdAndFolderId($userId, $folderId, $currentPage, $paginateUnit, $sortType);

        $actualAnimeNames = $animeList->pluck('name')->toArray();
        $this->assertEquals($anime1->name, $actualAnimeNames[0]);
        $this->assertEquals($anime2->name, $actualAnimeNames[1]);
        $this->assertEquals($anime3->name, $actualAnimeNames[2]);
    }

    // あるフォルダに所属するアニメを最新順に取得するテスト
    public function test_success_getAnimeListByUserIdAndFolderId__latest()
    {
        $userId = 1;
        $folderId = 1;

        $anime1 = $this->createAnime($userId, "アニメ1", "メモ", Anime::STATUS_ACTIVE, Carbon::now(), Carbon::now(), Carbon::now());
        $anime2 = $this->createAnime($userId, "アニメ2", "メモ", Anime::STATUS_ACTIVE, Carbon::now(), Carbon::now(), Carbon::now());
        $anime3 = $this->createAnime($userId, "アニメ3", "メモ", Anime::STATUS_ACTIVE, Carbon::now(), Carbon::now(), Carbon::now());

        $folderAnime1 = $this->createFolderAnime($userId, $folderId, $anime1->id, Anime::STATUS_ACTIVE, Carbon::now(), Carbon::now(), Carbon::now());
        $folderAnime2 = $this->createFolderAnime($userId, $folderId, $anime2->id, Anime::STATUS_ACTIVE, Carbon::now(), Carbon::now(), Carbon::now());
        $folderAnime3 = $this->createFolderAnime($userId, $folderId, $anime3->id, Anime::STATUS_ACTIVE, Carbon::now(), Carbon::now(), Carbon::now());

        $currentPage = 1;
        $paginateUnit = 20;
        $sortType = 'latest';
        $animeList = \FolderAnimeRelationService::getAnimeListByUserIdAndFolderId($userId, $folderId, $currentPage, $paginateUnit, $sortType);

        $actualAnimeNames = $animeList->pluck('name')->toArray();
        $this->assertEquals($anime1->name, $actualAnimeNames[2]);
        $this->assertEquals($anime2->name, $actualAnimeNames[1]);
        $this->assertEquals($anime3->name, $actualAnimeNames[0]);
    }

    // あるフォルダに所属するアニメを名前順に取得するテスト
    public function test_success_getAnimeListByUserIdAndFolderId__title()
    {
        $userId = 1;
        $folderId = 1;

        $anime1 = $this->createAnime($userId, "アニメ1", "メモ", Anime::STATUS_ACTIVE, Carbon::now(), Carbon::now(), Carbon::now());
        $anime2 = $this->createAnime($userId, "アニメ3", "メモ", Anime::STATUS_ACTIVE, Carbon::now(), Carbon::now(), Carbon::now());
        $anime3 = $this->createAnime($userId, "アニメ2", "メモ", Anime::STATUS_ACTIVE, Carbon::now(), Carbon::now(), Carbon::now());

        $folderAnime1 = $this->createFolderAnime($userId, $folderId, $anime1->id, Anime::STATUS_ACTIVE, Carbon::now(), Carbon::now(), Carbon::now());
        $folderAnime2 = $this->createFolderAnime($userId, $folderId, $anime2->id, Anime::STATUS_ACTIVE, Carbon::now(), Carbon::now(), Carbon::now());
        $folderAnime3 = $this->createFolderAnime($userId, $folderId, $anime3->id, Anime::STATUS_ACTIVE, Carbon::now(), Carbon::now(), Carbon::now());

        $currentPage = 1;
        $paginateUnit = 20;
        $sortType = 'title';
        $animeList = \FolderAnimeRelationService::getAnimeListByUserIdAndFolderId($userId, $folderId, $currentPage, $paginateUnit, $sortType);

        $actualAnimeNames = $animeList->pluck('name')->toArray();
        $this->assertEquals($anime1->name, $actualAnimeNames[0]);
        $this->assertEquals($anime3->name, $actualAnimeNames[1]);
        $this->assertEquals($anime2->name, $actualAnimeNames[2]);
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
        $folder = $this->createFolder($userId, $name, Folder::STATUS_ACTIVE, $now, $now, $now);

        $retrievedFolder = \FolderAnimeRelationService::getFolderByUserIdAndFolderName($userId, $name);
        $this->assertInstanceOf(Folder::class, $retrievedFolder);
        $this->assertEquals($folder->user_id, $retrievedFolder->user_id);
        $this->assertEquals($folder->name, $retrievedFolder->name);
    }

    // userId と animeName からアニメを取得するテスト
    public function test_success_getAnimeByUserIdAndAnimeName()
    {
        $userId = 1;
        $name = "アニメ1";

        $now = Carbon::now();
        $anime = $this->createAnime($userId, "アニメ1", "メモ", Anime::STATUS_ACTIVE, $now, $now, $now);

        $retrievedAnime = \FolderAnimeRelationService::getAnimeByUserIdAndAnimeName($userId, $name);
        $this->assertInstanceOf(Anime::class, $retrievedAnime);
        $this->assertEquals($anime->user_id, $retrievedAnime->user_id);
        $this->assertEquals($anime->name, $retrievedAnime->name);
    }

    // userId と folderId ,animeId からアニメを取得するテスト
    public function test_success_getFolderAnimeRelationByUserIdAndFolderIdAndAnimeId()
    {
        $userId = 1;
        $folderId = 1;
        $animeId = 1;

        $now = Carbon::now();
        $folderAnimeRelation = $this->createFolderAnime($userId, $folderId, $animeId, FolderAnimeRelation::STATUS_ACTIVE, $now, $now, $now);

        $retrievedRelation = \FolderAnimeRelationService::getFolderAnimeRelationByUserIdAndFolderIdAndAnimeId($userId, $folderId, $animeId);

        $this->assertInstanceOf(FolderAnimeRelation::class, $retrievedRelation);
        $this->assertEquals($folderAnimeRelation->user_id, $retrievedRelation->user_id);
        $this->assertEquals($folderAnimeRelation->folder_id, $retrievedRelation->folder_id);
        $this->assertEquals($folderAnimeRelation->anime_id, $retrievedRelation->anime_id);
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
    }

    // フォルダに新しいアニメを追加する際にそのアニメが存在する場合のテスト
    public function test_success_createFolderAnimeRelation__status_active()
    {
        $userId = 1;
        $folderId = 1;
        $animeId = 1;

        $now = Carbon::now();
        $expectedFolderAnimeRelation = $this->createFolderAnime($userId, $folderId, $animeId, FolderAnimeRelation::STATUS_ACTIVE, $now, $now, $now);

        $folderAnimeRelation = \FolderAnimeRelationService::createFolderAnimeRelation($userId, $folderId, $animeId);
        $count = FolderAnimeRelation::count();

        $this->assertInstanceOf(FolderAnimeRelation::class, $folderAnimeRelation);
        $this->assertEquals($expectedFolderAnimeRelation->user_id, $folderAnimeRelation->user_id);
        $this->assertEquals($expectedFolderAnimeRelation->id, $folderAnimeRelation->id);
        $this->assertEquals($expectedFolderAnimeRelation->folder_id, $folderAnimeRelation->folder_id);
        $this->assertEquals($expectedFolderAnimeRelation->anime_id, $folderAnimeRelation->anime_id);
        $this->assertEquals(FolderAnimeRelation::STATUS_ACTIVE, $folderAnimeRelation->status);
        $this->assertEquals(1, $count);
    }

    // フォルダに新しいアニメを作成する際にそのアニメが削除されていた場合のテスト
    public function test_success_createFolderAnimeRelation__status_deleted()
    {
        $userId = 1;
        $folderId = 1;
        $animeId = 1;

        $now = Carbon::now();
        $expectedFolderAnimeRelation = $this->createFolderAnime($userId, $folderId, $animeId, FolderAnimeRelation::STATUS_DELETED, $now, $now, $now);

        $folderAnimeRelation = \FolderAnimeRelationService::createFolderAnimeRelation($userId, $folderId, $animeId);
        $count = FolderAnimeRelation::count();

        $this->assertInstanceOf(FolderAnimeRelation::class, $folderAnimeRelation);
        $this->assertEquals($expectedFolderAnimeRelation->user_id, $folderAnimeRelation->user_id);
        $this->assertEquals($expectedFolderAnimeRelation->id, $folderAnimeRelation->id);
        $this->assertEquals($expectedFolderAnimeRelation->folder_id, $folderAnimeRelation->folder_id);
        $this->assertEquals($expectedFolderAnimeRelation->anime_id, $folderAnimeRelation->anime_id);
        $this->assertEquals(FolderAnimeRelation::STATUS_ACTIVE, $folderAnimeRelation->status);
        $this->assertEquals(1, $count);
    }

    // フォルダに新しいアニメを作成する際にそのアニメの status が存在しない値の場合のテスト
    public function test_failure_createFolderAnimeRelation__anime_state_not_found()
    {
        $userId = 1;
        $folderId = 1;
        $animeId = 1;

        $now = Carbon::now();
        $expectedFolderAnimeRelation = $this->createFolderAnime($userId, $folderId, $animeId, "anime", $now, $now, $now);

        $this->expectException(FolderAnimeRelationStateNotFoundException::class);

        \FolderAnimeRelationService::createFolderAnimeRelation($userId, $folderId, $animeId);
    }


    // フォルダ内でアニメを検索する際にそのキーワードのアニメが存在する場合のテスト
    public function test_success_searchFolderAnime()
    {
        $userId = 1;
        $folderId = 1;

        $now = Carbon::now();
        // 1が半角の場合
        $anime1 = $this->createAnime($userId, "アニメ1", "メモ", Anime::STATUS_ACTIVE, $now, $now, $now);
        // １が全角場合
        $anime2 = $this->createAnime($userId, "アニメ１", "メモ", Anime::STATUS_ACTIVE, $now, $now, $now);
        $anime3 = $this->createAnime($userId, "アニメa", "メモ", Anime::STATUS_ACTIVE, $now, $now, $now);
        $anime4 = $this->createAnime($userId, "アニメA", "メモ", Anime::STATUS_ACTIVE, $now, $now, $now);

        $folderAnimeRelation1 = $this->createFolderAnime($userId, $folderId, $anime1->id, FolderAnimeRelation::STATUS_ACTIVE, $now, $now, $now);
        $folderAnimeRelation2 = $this->createFolderAnime($userId, $folderId, $anime2->id, FolderAnimeRelation::STATUS_ACTIVE, $now, $now, $now);
        $folderAnimeRelation3 = $this->createFolderAnime($userId, $folderId, $anime3->id, FolderAnimeRelation::STATUS_ACTIVE, $now, $now, $now);
        $folderAnimeRelation4 = $this->createFolderAnime($userId, $folderId, $anime4->id, FolderAnimeRelation::STATUS_ACTIVE, $now, $now, $now);

        // 半角と全角の違いを確認するテスト
        $animeList1 = \FolderAnimeRelationService::searchFolderAnime($userId, $folderId, "1");
        $this->assertCount(1, $animeList1);
        $this->assertEquals($anime1->name, $animeList1[0]->name);

        // 大文字と小文字の区別はされないことを確認するテスト
        $animeList2 = \FolderAnimeRelationService::searchFolderAnime($userId, $folderId, "a");
        $this->assertCount(2, $animeList2);
        $this->assertEquals($anime3->name, $animeList2[0]->name);
    }

    // アニメをレコードに保存する関数。
    private function createAnime(int $userId, string $name, string $memo, string $status, string $latest_changed_at, string $created_at, string $updated_at)
    {
        $anime = new Anime();
        $anime->user_id = $userId;
        $anime->name = $name;
        $anime->memo = $memo;
        $anime->status = $status;
        $anime->latest_changed_at = $latest_changed_at;
        $anime->created_at = $created_at;
        $anime->updated_at = $updated_at;
        $anime->save();

        return $anime;
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

    // フォルダアニメをレコードに保存する関数。
    private function createFolderAnime(int $userId, int $folderId, int $animeId, string $status, string $latest_changed_at, string $created_at, string $updated_at)
    {
        $folderAnimeRelation = new FolderAnimeRelation();
        $folderAnimeRelation->user_id = $userId;
        $folderAnimeRelation->folder_id = $folderId;
        $folderAnimeRelation->anime_id = $animeId;
        $folderAnimeRelation->status = $status;
        $folderAnimeRelation->latest_changed_at = $latest_changed_at;
        $folderAnimeRelation->created_at = $created_at;
        $folderAnimeRelation->updated_at = $updated_at;
        $folderAnimeRelation->save();

        return $folderAnimeRelation;
    }
}

