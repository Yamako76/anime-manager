<?php

use Inertia\Inertia;

/**
 * TOP画面URLの設定
 */
\Route::get('/', [App\Http\Controllers\Top\IndexController::class, 'index']);

/**
 * ゲストログインのURLの設定
 */
\Route::get('/guest', [App\Http\Controllers\Auth\LoginController::class, 'guestLogin']);

/**
 * 画面関連のURL設定
 */
\Route::middleware('auth')->group(function () {
    /**
     * Profile関連のURL設定
     */
    \Route::prefix('profile')->group(function () {
        \Route::get('/', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
        \Route::patch('/', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
        \Route::delete('/', [App\Http\Controllers\ProfileController::class, 'destroy'])->name('profile.destroy');
    });

    /**
     * アニメ関連画面のURL設定
     */
    \Route::prefix('anime-list')->group(function () {
        \Route::get('/', [App\Http\Controllers\Anime\IndexController::class, 'index']);
        \Route::get('/{animeId}', [App\Http\Controllers\Anime\AnimeController::class, 'index']);
    });

    /**
     * フォルダ関連画面のURL設定
     */
    \Route::prefix('folders')->group(function () {
        \Route::get('/', [App\Http\Controllers\Folder\IndexController::class, 'index']);
        \Route::get('/{folderId}', [App\Http\Controllers\Folder\FolderController::class, 'index']);
    });
});

/**
 * APIのURL設定
 */
Route::middleware('auth')->prefix('api')->group(function () {
    /**
     * アニメ関連のURL設定
     */
    \Route::prefix('anime-list')->group(function () {
        \Route::get('/', [App\Http\Controllers\Api\Anime\IndexController::class, 'index']);
        \Route::get('/search', [App\Http\Controllers\Api\Anime\Search\IndexController::class, 'index']);
        \Route::post('/', [App\Http\Controllers\Api\Anime\Create\IndexController::class, 'index']);
        \Route::put('/{animeId}', [App\Http\Controllers\Api\Anime\Update\IndexController::class, 'index']);
        \Route::delete('/{animeId}', [App\Http\Controllers\Api\Anime\Delete\IndexController::class, 'index']);
    });

    /**
     * フォルダ関連のURL設定
     */
    \Route::prefix('folders')->group(function () {
        \Route::get('/', [App\Http\Controllers\Api\Folder\IndexController::class, 'index']);
        \Route::get('/search', [App\Http\Controllers\Api\Folder\Search\IndexController::class, 'index']);
        \Route::post('/', [App\Http\Controllers\Api\Folder\Create\IndexController::class, 'index']);
        \Route::put('/{folderId}', [App\Http\Controllers\Api\Folder\Update\IndexController::class, 'index']);
        \Route::delete('/{folderId}', [App\Http\Controllers\Api\Folder\Delete\IndexController::class, 'index']);
    });

    /**
     * フォルダにアニメを紐付ける関連のURL設定
     */
    \Route::prefix('folders/{folderId}')->group(function () {
        \Route::get('/anime-list', [App\Http\Controllers\Api\FolderAnimeRelation\IndexController::class, 'index']);
        \Route::get('/anime-list/search', [App\Http\Controllers\Api\FolderAnimeRelation\Search\IndexController::class, 'index']);
        \Route::post('/anime-list', [App\Http\Controllers\Api\FolderAnimeRelation\Create\IndexController::class, 'index']);
        \Route::delete('/anime-list/{animeId}', [App\Http\Controllers\Api\FolderAnimeRelation\Delete\IndexController::class, 'index']);
    });
});

\Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__ . '/auth.php';
