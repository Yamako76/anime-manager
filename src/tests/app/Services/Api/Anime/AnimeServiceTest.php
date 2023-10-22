<?php

namespace Tests\app\Services\Api\Anime;

use App\Models\Anime;
use App\Models\User;
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

    public function test_failure_getAnimeListByUserId__invalid_arguments()
    {
        $this->assertTrue(true);

    }

    public function test_success_createAnimeRecord()
    {
        $this->assertTrue(true);

    }

    public function test_success_getAnimeByIdAndUserId()
    {
        $this->assertTrue(true);

    }

    public function test_success_getAnimeByUserIdAndName()
    {
        $this->assertTrue(true);

    }

    public function test_success_createAnime__record_new_anime()
    {
        $this->assertTrue(true);

    }

    public function test_success_createAnime__status_active()
    {
        $this->assertTrue(true);

    }

    public function test_success_createAnime__status_deleted()
    {
        $this->assertTrue(true);

    }

    public function test_failure_createAnime__anime_state_not_found()
    {
        $this->assertTrue(true);

    }

    public function test_success_updateAnimeRecord()
    {
        $this->assertTrue(true);

    }

    public function test_success_searchAnime()
    {
        $this->assertTrue(true);

    }

}

