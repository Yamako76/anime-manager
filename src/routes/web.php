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
        \Route::get('/create', [App\Http\Controllers\Anime\Create\IndexController::class, 'index']);
        \Route::get('/{id}', [App\Http\Controllers\Anime\AnimeController::class, 'index']);
        \Route::get('/{id}/edit', [App\Http\Controllers\Anime\Edit\IndexController::class, 'index']);
    });

    /**
     * フォルダ関連画面のURL設定
     */
    \Route::prefix('folders')->group(function () {
        \Route::get('/', [App\Http\Controllers\Folder\IndexController::class, 'index']);
        \Route::get('/create', [App\Http\Controllers\Folder\Create\IndexController::class, 'index']);
        \Route::get('/{id}', [App\Http\Controllers\Folder\FolderController::class, 'index']);
        \Route::get('/{id}/edit', [App\Http\Controllers\Folder\Edit\IndexController::class, 'index']);
    });

    /**
     * タグ関連のURL設定
     */
    \Route::prefix('tags')->group(function () {
        \Route::get('/', [App\Http\Controllers\Tag\IndexController::class, 'index']);
        \Route::get('/create', [App\Http\Controllers\Tag\Create\IndexController::class, 'index']);
        \Route::get('/{id}', [App\Http\Controllers\Tag\TagController::class, 'index']);
        \Route::get('/tag/{id}/edit', [App\Http\Controllers\Tag\Edit\IndexController::class, 'index']);
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
    });
});

\Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__ . '/auth.php';
