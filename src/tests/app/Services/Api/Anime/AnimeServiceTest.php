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
        $expectedAnimeNames = [];

        for ($i = 1; $i <= 20; $i++) {
            $animeName = "アニメ{$i}";
            $expectedAnimeNames[] = $animeName;

            $anime = new Anime();
            $customDateTime = Carbon::parse("20{$i}-01-01 00:00:00");
            $anime->user_id = $userId;
            $anime->status = Anime::STATUS_ACTIVE;
            $anime->name = "アニメ{$i}";
            $anime->memo = 'This is a memo.';
            $anime->latest_changed_at = $customDateTime;
            $anime->created_at = $customDateTime;
            $anime->updated_at = $customDateTime;
            $anime->save();
        }

        $currentPage = 1;
        $paginateUnit = 20;
        $sortType = 'created_at';
        $animeList = \AnimeService::getAnimeListByUserId($userId, $currentPage, $paginateUnit, $sortType);

        $actualAnimeNames = $animeList->pluck('name')->toArray();

        $this->assertEquals($expectedAnimeNames, $actualAnimeNames);

        $this->refreshApplication();
    }

    // アニメを最新順に取得するテスト
    public function test_success_getAnimeListByUserId__latest()
    {
        $userId = 1;
        $expectedAnimeNames = [];

        for ($i = 1; $i <= 20; $i++) {
            Anime::create([
                'user_id' => $userId,
                'status' => Anime::STATUS_ACTIVE,
                'name' => "アニメ{$i}",
                'memo' => 'This is a memo.',
                'latest_changed_at' => now(),
            ]);
        }

        for ($i = 20; $i > 0; $i--) {
            $animeName = "アニメ{$i}";
            $expectedAnimeNames[] = $animeName;
        }

        $currentPage = 1;
        $paginateUnit = 20;
        $sortType = 'latest';
        $animeList = \AnimeService::getAnimeListByUserId($userId, $currentPage, $paginateUnit, $sortType);

        $actualAnimeNames = $animeList->pluck('name')->toArray();
        $this->assertEquals($expectedAnimeNames, $actualAnimeNames);

        $this->refreshApplication();
    }

    // アニメを名前順に取得するテスト
    public function test_success_getAnimeListByUserId__title()
    {
        $userId = 1;
        $expectedAnimeNames = [];

        for ($i = 1; $i <= 20; $i++) {
            $animeName = "アニメ{$i}";
            $expectedAnimeNames[] = $animeName;

            Anime::create([
                'user_id' => $userId,
                'status' => Anime::STATUS_ACTIVE,
                'name' => "アニメ{$i}",
                'memo' => 'This is a memo.',
                'latest_changed_at' => now(),
            ]);
        }

        $currentPage = 1;
        $paginateUnit = 20;
        $sortType = 'title';
        $animeList = \AnimeService::getAnimeListByUserId($userId, $currentPage, $paginateUnit, $sortType);

        sort($expectedAnimeNames);
        $actualAnimeNames = $animeList->pluck('name')->toArray();
        $this->assertEquals($expectedAnimeNames, $actualAnimeNames);

        $this->refreshApplication();
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

        $this->assertInstanceOf(Anime::class, $anime);
        $this->assertEquals($userId, $anime->user_id);
        $this->assertEquals($name, $anime->name);
        $this->assertEquals($memo, $anime->memo);
        $this->assertEquals(Anime::STATUS_ACTIVE, $anime->status);
        $this->assertNotNull($anime->latest_changed_at);
        $this->assertNotNull($anime->created_at);
        $this->assertNotNull($anime->updated_at);

        $this->refreshApplication();
    }

    // アニメを animeId, userId から取得するテスト
    public function test_success_getAnimeByIdAndUserId()
    {
        $userId = 1;
        $animeId = 1;

        $now = Carbon::now();
        $anime = new Anime();
        $anime->user_id = $userId;
        $anime->name = "Anime";
        $anime->memo = "test";
        $anime->status = Anime::STATUS_ACTIVE;
        $anime->latest_changed_at = $now;
        $anime->created_at = $now;
        $anime->updated_at = $now;
        $anime->save();

        $retrievedAnime = \AnimeService::getAnimeByIdAndUserId($animeId, $userId);
        $this->assertInstanceOf(Anime::class, $retrievedAnime);
        $this->assertEquals($userId, $retrievedAnime->user_id);
        $this->assertEquals($animeId, $retrievedAnime->id);

        $this->refreshApplication();
    }

    // アニメを animeId, userId から取得する際にアニメが存在しない場合のテスト
    public function test_getAnimeByIdAndUserId_return_null()
    {
        $animeId = 999;
        $userId = 1;

        $result = \AnimeService::getAnimeByIdAndUserId($animeId, $userId);
        $this->assertNull($result);
    }

    // アニメを name, userId から取得するテスト
    public function test_success_getAnimeByUserIdAndName()
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

        $retrievedAnime = \AnimeService::getAnimeByUserIdAndName($userId, $name);
        $this->assertInstanceOf(Anime::class, $retrievedAnime);
        $this->assertEquals($userId, $retrievedAnime->user_id);
        $this->assertEquals($name, $retrievedAnime->name);

        $this->refreshApplication();
    }

    // アニメを name, userId から取得する際にアニメが存在しない場合のテスト
    public function test_success_getAnimeByUserIdAndName_return_null()
    {
        $name = "アニメ999";
        $userId = 1;

        $result = \AnimeService::getAnimeByUserIdAndName($userId, $name);
        $this->assertNull($result);
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

        $this->refreshApplication();
    }

    // 新しいアニメを作成する際にそのアニメが存在する場合のテスト
    public function test_success_createAnime__status_active()
    {
        $userId = 1;
        $name = "アニメ1";
        $memo = "test";

        $now = Carbon::now();
        $anime = new Anime();
        $anime->user_id = $userId;
        $anime->name = $name;
        $anime->memo = $memo;
        $anime->status = Anime::STATUS_ACTIVE;
        $anime->latest_changed_at = $now;
        $anime->created_at = $now;
        $anime->updated_at = $now;
        $anime->save();

        $anime = \AnimeService::createAnime($userId, $name, $memo);

        $this->assertInstanceOf(Anime::class, $anime);
        $this->assertEquals($userId, $anime->user_id);
        $this->assertEquals(1, $anime->id);
        $this->assertEquals($name, $anime->name);
        $this->assertEquals($memo, $anime->memo);
        $this->assertEquals(Anime::STATUS_ACTIVE, $anime->status);

        $this->refreshApplication();
    }

    // 新しいアニメを作成する際にそのアニメが削除されていた場合のテスト
    public function test_success_createAnime__status_deleted()
    {
        $userId = 1;
        $name = "アニメ1";
        $memo = "test";

        $now = Carbon::now();
        $anime = new Anime();
        $anime->user_id = $userId;
        $anime->name = $name;
        $anime->memo = $memo;
        $anime->status = Anime::STATUS_DELETED;
        $anime->latest_changed_at = $now;
        $anime->created_at = $now;
        $anime->updated_at = $now;
        $anime->save();

        $anime = \AnimeService::createAnime($userId, $name, $memo);

        $this->assertInstanceOf(Anime::class, $anime);
        $this->assertEquals($userId, $anime->user_id);
        $this->assertEquals(1, $anime->id);
        $this->assertEquals($name, $anime->name);
        $this->assertEquals($memo, $anime->memo);
        $this->assertEquals(Anime::STATUS_ACTIVE, $anime->status);

        $this->refreshApplication();
    }

    // 新しいアニメを作成する際にそのアニメの status が存在しない値の場合のテスト
    public function test_failure_createAnime__anime_state_not_found()
    {
        $userId = 1;
        $name = "アニメ1";
        $memo = "memo";

        $now = Carbon::now();
        $anime = new Anime();
        $anime->user_id = $userId;
        $anime->name = $name;
        $anime->memo = $memo;
        $anime->status = "anime";
        $anime->latest_changed_at = $now;
        $anime->created_at = $now;
        $anime->updated_at = $now;
        $anime->save();

        $this->expectException(AnimeStateNotFoundException::class);

        \AnimeService::createAnime($userId, $name, $memo);

        $this->refreshApplication();
    }

    // アニメを編集し新しい値が保存されていることのテスト
    public function test_success_updateAnimeRecord()
    {
        $now = Carbon::now();
        $anime = new Anime();
        $anime->user_id = 1;
        $anime->name = "アニメ";
        $anime->memo = "メモ";
        $anime->status = Anime::STATUS_ACTIVE;
        $anime->latest_changed_at = $now;
        $anime->created_at = $now;
        $anime->updated_at = $now;
        $anime->save();

        $newName = "Anime";
        $newMemo = "memo";

        $updatedAnime = \AnimeService::updateAnimeRecord($anime, $newName, $newMemo);

        $retrievedAnime = Anime::find($anime->id);

        $this->assertInstanceOf(Anime::class, $updatedAnime);
        $this->assertEquals($newName, $updatedAnime->name);
        $this->assertEquals($newMemo, $updatedAnime->memo);
        $this->assertEquals($anime->latest_changed_at->toDateTimeString(), $updatedAnime->latest_changed_at->toDateTimeString());

        $this->assertEquals($newName, $retrievedAnime->name);
        $this->assertEquals($newMemo, $retrievedAnime->memo);
        $this->assertEquals($anime->latest_changed_at->toDateTimeString(), $retrievedAnime->latest_changed_at);

        $this->refreshApplication();
    }

    // アニメを検索する際にそのキーワードのアニメが存在する場合のテスト
    public function test_success_searchAnime()
    {
        $userId = 1;
        $keyWord = "1";

        $anime1 = new Anime();
        $anime1->user_id = 1;
        $anime1->name = "アニメ1";
        $anime1->memo = "メモ1";
        $anime1->status = Anime::STATUS_ACTIVE;
        $anime1->latest_changed_at = Carbon::now();
        $anime1->created_at = Carbon::now();
        $anime1->updated_at = Carbon::now();
        $anime1->save();

        $anime2 = new Anime();
        $anime2->user_id = 1;
        $anime2->name = "アニメ2";
        $anime2->memo = "メモ2";
        $anime2->status = Anime::STATUS_ACTIVE;
        $anime2->latest_changed_at = Carbon::now();
        $anime2->created_at = Carbon::now();
        $anime2->updated_at = Carbon::now();
        $anime2->save();

        $animeList = \AnimeService::searchAnime($userId, $keyWord);

        $this->assertCount(1, $animeList);
        $this->assertEquals($anime1->name, $animeList[0]->name);

        $this->refreshApplication();
    }

    // アニメを検索する際にそのキーワードのアニメが存在しない場合のテスト
    public function test_success_searchAnime_no_match()
    {
        $userId = 1;
        $keyWord = "anime";

        $anime = new Anime();
        $anime->user_id = 1;
        $anime->name = "アニメ1";
        $anime->memo = "メモ1";
        $anime->status = Anime::STATUS_ACTIVE;
        $anime->latest_changed_at = Carbon::now();
        $anime->created_at = Carbon::now();
        $anime->updated_at = Carbon::now();
        $anime->save();


        $animeList = \AnimeService::searchAnime($userId, $keyWord);

        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Collection::class, $animeList);
        $this->assertCount(0, $animeList);

        $this->refreshApplication();
    }
}

