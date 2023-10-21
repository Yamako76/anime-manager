<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Anime;
use App\Models\Folder;
use App\Models\FolderAnimeRelation;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class sample extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $user = new User();
        $user->name = 'test';
        $user->email = 'test@example.com';
        $user->password = bcrypt('test_ps');
        $user->created_at = Carbon::now();
        $user->updated_at = Carbon::now();
        $user->save();

        for ($i = 1; $i <= 40; $i++) {
            $anime = new Anime();
            $anime->name = "アニメ" . $i;
            $anime->user_id = $user->user_id;
            $anime->memo = "memo";
            $anime->status = Anime::STATUS_ACTIVE;
            $anime->latest_changed_at = Carbon::now();
            $anime->created_at = Carbon::now();
            $anime->updated_at = Carbon::now();
            $anime->save();
        }

        $folder = new Folder();
        $folder->name = "コメディー";
        $folder->user_id = $user->user_id;
        $folder->status = Folder::STATUS_ACTIVE;
        $folder->latest_changed_at = Carbon::now();
        $folder->created_at = Carbon::now();
        $folder->updated_at = Carbon::now();
        $folder->save();

        $folder2 = new Folder();
        $folder2->name = "アクション";
        $folder2->user_id = $user->user_id;
        $folder2->status = "active";
        $folder2->latest_changed_at = Carbon::now();
        $folder2->created_at = Carbon::now();
        $folder2->updated_at = Carbon::now();
        $folder2->save();

        for ($i = 1; $i <= 40; $i++) {
            if ($i % 2 == 1) {
                $folderAnimeRelation = new FolderAnimeRelation();
                $folderAnimeRelation->user_id = $user->user_id;
                $folderAnimeRelation->folder_id = 1;
                $folderAnimeRelation->anime_id = $i;
                $folderAnimeRelation->status = FolderAnimeRelation::STATUS_ACTIVE;
                $folderAnimeRelation->latest_changed_at = Carbon::now();
                $folderAnimeRelation->created_at = Carbon::now();
                $folderAnimeRelation->updated_at = Carbon::now();
                $folderAnimeRelation->save();
            }
        }


    }
}
