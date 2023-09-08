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
        \Route::get('/{id}', [App\Http\Controllers\Anime\AnimeController::class, 'index']);
    });

    /**
     * フォルダ関連画面のURL設定
     */
    \Route::prefix('folders')->group(function () {
        \Route::get('/', [App\Http\Controllers\Folder\IndexController::class, 'index']);
        \Route::get('/{id}', [App\Http\Controllers\Folder\FolderController::class, 'index']);
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
        \Route::get('/{id}', [App\Http\Controllers\Api\Anime\IndexController::class, 'show']);
        \Route::post('/', [App\Http\Controllers\Api\Anime\IndexController::class, 'create']);
        \Route::put('/{id}', [App\Http\Controllers\Api\Anime\IndexController::class, 'update']);
        \Route::delete('/{id}', [App\Http\Controllers\Api\Anime\IndexController::class, 'delete']);
    });
});

\Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__ . '/auth.php';
