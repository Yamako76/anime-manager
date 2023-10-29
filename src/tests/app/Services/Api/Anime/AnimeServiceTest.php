<?php

namespace Tests\app\Services\Api\Anime;

use App\Models\Anime;
use App\Services\Api\Anime\State\AnimeStateNotFoundException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class AnimeServiceTest extends TestCase
{
    use DatabaseTransactions;

    public function setUp(): void
    {
        parent::setUp();
    }

    // アニメを作成順に取得するテスト
    public function test_success_getAnimeListByUserId__created_at()
    {
        $userId = 1;

        $anime1 = $this->createAnime($userId, "アニメ1", "メモ", Anime::STATUS_ACTIVE, Carbon::now(), Carbon::now(), Carbon::now());
        $anime2 = $this->createAnime($userId, "アニメ2", "メモ", Anime::STATUS_ACTIVE, Carbon::now(), Carbon::now(), Carbon::now());
        $anime3 = $this->createAnime($userId, "アニメ3", "メモ", Anime::STATUS_ACTIVE, Carbon::now(), Carbon::now(), Carbon::now());

        $currentPage = 1;
        $paginateUnit = 20;
        $sortType = 'created_at';
        $animeList = \AnimeService::getAnimeListByUserId($userId, $currentPage, $paginateUnit, $sortType);

        $actualAnimeNames = $animeList->pluck('name')->toArray();

        $this->assertEquals($anime1->name, $actualAnimeNames[0]);
        $this->assertEquals($anime2->name, $actualAnimeNames[1]);
        $this->assertEquals($anime3->name, $actualAnimeNames[2]);
    }

    // アニメを最新順に取得するテスト
    public function test_success_getAnimeListByUserId__latest()
    {
        $userId = 1;

        $anime1 = $this->createAnime($userId, "アニメ1", "メモ", Anime::STATUS_ACTIVE, Carbon::now(), Carbon::now(), Carbon::now());
        $anime2 = $this->createAnime($userId, "アニメ2", "メモ", Anime::STATUS_ACTIVE, Carbon::now(), Carbon::now(), Carbon::now());
        $anime3 = $this->createAnime($userId, "アニメ3", "メモ", Anime::STATUS_ACTIVE, Carbon::now(), Carbon::now(), Carbon::now());

        $currentPage = 1;
        $paginateUnit = 20;
        $sortType = 'latest';
        $animeList = \AnimeService::getAnimeListByUserId($userId, $currentPage, $paginateUnit, $sortType);

        $actualAnimeNames = $animeList->pluck('name')->toArray();
        $this->assertEquals($anime1->name, $actualAnimeNames[2]);
        $this->assertEquals($anime2->name, $actualAnimeNames[1]);
        $this->assertEquals($anime3->name, $actualAnimeNames[0]);
    }

    // アニメを名前順に取得するテスト
    public function test_success_getAnimeListByUserId__title()
    {
        $userId = 1;

        $anime1 = $this->createAnime($userId, "アニメ1", "メモ", Anime::STATUS_ACTIVE, Carbon::now(), Carbon::now(), Carbon::now());
        $anime2 = $this->createAnime($userId, "アニメ3", "メモ", Anime::STATUS_ACTIVE, Carbon::now(), Carbon::now(), Carbon::now());
        $anime3 = $this->createAnime($userId, "アニメ2", "メモ", Anime::STATUS_ACTIVE, Carbon::now(), Carbon::now(), Carbon::now());

        $currentPage = 1;
        $paginateUnit = 20;
        $sortType = 'title';
        $animeList = \AnimeService::getAnimeListByUserId($userId, $currentPage, $paginateUnit, $sortType);

        $actualAnimeNames = $animeList->pluck('name')->toArray();
        $this->assertEquals($anime1->name, $actualAnimeNames[0]);
        $this->assertEquals($anime3->name, $actualAnimeNames[1]);
        $this->assertEquals($anime2->name, $actualAnimeNames[2]);
    }

    // アニメ取得の際に無効なソートタイプのテスト
    public function test_failure_getAnimeListByUserId__invalid_arguments()
    {
        $this->expectException(\InvalidArgumentException::class);

        $userId = 1;
        $currentPage = 1;
        $paginateUnit = 20;
        $sortType = 'invalid_sort_type';
        \AnimeService::getAnimeListByUserId($userId, $currentPage, $paginateUnit, $sortType);
    }

    // アニメをレコードに保存するテスト
    public function test_success_createAnimeRecord()
    {
        $userId = 1;
        $name = "Anime";
        $memo = "test";

        $anime = \AnimeService::createAnimeRecord($userId, $name, $memo);

        $this->assertEquals($userId, $anime->user_id);
        $this->assertEquals($name, $anime->name);
        $this->assertEquals($memo, $anime->memo);
        $this->assertEquals(Anime::STATUS_ACTIVE, $anime->status);
        $this->assertNotNull($anime->latest_changed_at);
        $this->assertNotNull($anime->created_at);
        $this->assertNotNull($anime->updated_at);
    }

    // アニメを animeId, userId から取得するテスト
    public function test_success_getAnimeByIdAndUserId()
    {
        $userId = 1;
        $animeId = 1;

        $now = Carbon::now();
        $anime = $this->createAnime($userId, "アニメ1", "メモ", Anime::STATUS_ACTIVE, $now, $now, $now);

        $retrievedAnime = \AnimeService::getAnimeByIdAndUserId($animeId, $userId);
        $this->assertInstanceOf(Anime::class, $retrievedAnime);
        $this->assertEquals($anime->user_id, $retrievedAnime->user_id);
        $this->assertEquals($anime->id, $retrievedAnime->id);
    }

    // アニメを name, userId から取得するテスト
    public function test_success_getAnimeByUserIdAndName()
    {
        $userId = 1;
        $name = "アニメ1";

        $now = Carbon::now();
        $anime = $this->createAnime($userId, "アニメ1", "メモ", Anime::STATUS_ACTIVE, $now, $now, $now);

        $retrievedAnime = \AnimeService::getAnimeByUserIdAndName($userId, $name);
        $this->assertInstanceOf(Anime::class, $retrievedAnime);
        $this->assertEquals($anime->user_id, $retrievedAnime->user_id);
        $this->assertEquals($anime->name, $retrievedAnime->name);
    }

    // 新しいアニメを作成するテスト
    public function test_success_createAnime__record_new_anime()
    {
        $userId = 1;
        $name = "アニメ1";
        $memo = "memo";

        $anime = \AnimeService::createAnime($userId, $name, $memo);

        $this->assertInstanceOf(Anime::class, $anime);
        $this->assertEquals($userId, $anime->user_id);
        $this->assertEquals(1, $anime->id);
        $this->assertEquals($name, $anime->name);
        $this->assertEquals($memo, $anime->memo);
    }

    // 新しいアニメを作成する際にそのアニメが存在する場合のテスト
    public function test_success_createAnime__status_active()
    {
        $userId = 1;
        $name = "アニメ1";
        $memo = "test";

        $now = Carbon::now();
        $expectedAnime = $this->createAnime($userId, $name, $memo, Anime::STATUS_ACTIVE, $now, $now, $now);

        $anime = \AnimeService::createAnime($userId, $name, $memo);
        $count = Anime::count();

        $this->assertInstanceOf(Anime::class, $anime);
        $this->assertEquals($expectedAnime->user_id, $anime->user_id);
        $this->assertEquals($expectedAnime->id, $anime->id);
        $this->assertEquals($expectedAnime->name, $anime->name);
        $this->assertEquals($expectedAnime->memo, $anime->memo);
        $this->assertEquals($expectedAnime->status, $anime->status);
        $this->assertEquals(1, $count);
    }

    // 新しいアニメを作成する際にそのアニメが削除されていた場合のテスト
    public function test_success_createAnime__status_deleted()
    {
        $userId = 1;
        $name = "アニメ1";
        $memo = "test";

        $now = Carbon::now();
        $expectedAnime = $this->createAnime($userId, $name, $memo, Anime::STATUS_DELETED, $now, $now, $now);

        $anime = \AnimeService::createAnime($userId, $name, $memo);
        $count = Anime::count();

        $this->assertInstanceOf(Anime::class, $anime);
        $this->assertEquals($expectedAnime->user_id, $anime->user_id);
        $this->assertEquals($expectedAnime->id, $anime->id);
        $this->assertEquals($expectedAnime->name, $anime->name);
        $this->assertEquals($expectedAnime->memo, $anime->memo);
        $this->assertEquals(Anime::STATUS_ACTIVE, $anime->status);
        $this->assertEquals(1, $count);
    }

    // 新しいアニメを作成する際にそのアニメの status が存在しない値の場合のテスト
    public function test_failure_createAnime__anime_state_not_found()
    {
        $userId = 1;
        $name = "アニメ1";
        $memo = "memo";

        $now = Carbon::now();
        $anime = $this->createAnime($userId, $name, $memo, "anime", $now, $now, $now);

        $this->expectException(AnimeStateNotFoundException::class);

        \AnimeService::createAnime($userId, $name, $memo);
    }

    // アニメを編集し新しい値が保存されていることのテスト
    public function test_success_updateAnimeRecord()
    {
        $userId = 1;
        $name = "アニメ1";
        $memo = "メモ";

        $now = Carbon::now();
        $anime = $this->createAnime($userId, $name, $memo, Anime::STATUS_ACTIVE, $now, $now, $now);

        $newName = "Anime";
        $newMemo = "memo";

        $updatedAnime = \AnimeService::updateAnimeRecord($anime, $newName, $newMemo);

        $this->assertInstanceOf(Anime::class, $updatedAnime);
        $this->assertEquals($newName, $updatedAnime->name);
        $this->assertEquals($newMemo, $updatedAnime->memo);
    }

    public function test_success_searchAnime()
    {
        $userId = 1;

        $now = Carbon::now();
        // 1が半角の場合
        $anime1 = $this->createAnime($userId, "アニメ1", "メモ", Anime::STATUS_ACTIVE, $now, $now, $now);
        // １が全角場合
        $anime2 = $this->createAnime($userId, "アニメ１", "メモ", Anime::STATUS_ACTIVE, $now, $now, $now);
        $anime3 = $this->createAnime($userId, "アニメa", "メモ", Anime::STATUS_ACTIVE, $now, $now, $now);
        $anime4 = $this->createAnime($userId, "アニメA", "メモ", Anime::STATUS_ACTIVE, $now, $now, $now);

        // 半角と全角の違いを確認するテスト
        $animeList1 = \AnimeService::searchAnime($userId, "1");
        $this->assertCount(1, $animeList1);
        $this->assertEquals($anime1->name, $animeList1[0]->name);

        // 大文字と小文字の区別はされないことを確認するテスト
        $animeList2 = \AnimeService::searchAnime($userId, "A");
        $this->assertCount(2, $animeList2);
        $this->assertEquals($anime4->name, $animeList2[0]->name);
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

}

