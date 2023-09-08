<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Anime;
use App\Models\Folder;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class test extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
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
            $anime->status = "active";
            $anime->latest_changed_at = Carbon::now();
            $anime->created_at = Carbon::now();
            $anime->updated_at = Carbon::now();
            $anime->save();
        }

        $folder = new Folder();
        $folder->name = "コメディー";
        $folder->user_id = $user->user_id;
        $folder->status = "active";
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


    }
}
