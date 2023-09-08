<?php

use Inertia\Inertia;

/**
 * TOP画面URLの設定
 */
\Route::get('/', [App\Http\Controllers\Top\IndexController::class, 'index']);

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
        \Route::get('/{anime}', [App\Http\Controllers\Anime\AnimeController::class, 'index']);
    });

    /**
     * フォルダ関連画面のURL設定
     */
    \Route::prefix('folders')->group(function () {
        \Route::get('/', [App\Http\Controllers\Folder\IndexController::class, 'index']);
        \Route::get('/{folder}', [App\Http\Controllers\Folder\FolderController::class, 'index']);
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
        \Route::get('/{anime}', [App\Http\Controllers\Api\Anime\AnimeController::class, 'index']);
        \Route::post('/', [App\Http\Controllers\Api\Anime\Create\IndexController::class, 'index']);
//        \Route::put('/{anime}', [App\Http\Controllers\Api\Anime\Update\IndexController::class, 'index']);
//        \Route::delete('/{anime}', [App\Http\Controllers\Api\Anime\Delete\IndexController::class, 'index']);
    });

    /**
     * フォルダ関連のURL設定
     */
    \Route::prefix('folders')->group(function () {
        \Route::get('/', [App\Http\Controllers\Api\Folder\IndexController::class, 'index']);
        \Route::get('/{folder}', [App\Http\Controllers\Api\Folder\FolderController::class, 'index']);
        \Route::post('/', [App\Http\Controllers\Api\Folder\Create\IndexController::class, 'index']);
    });
});

\Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__ . '/auth.php';
