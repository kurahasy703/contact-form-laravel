<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\TagController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- 1. 一般ユーザー用：お問い合わせフォーム（公開ルート） ---
Route::get('/', [ContactController::class, 'index'])->name('contact.index');

// GETで /confirm に直接アクセスされた場合は入力画面へリダイレクト
Route::get('/confirm', function () {
    return redirect()->route('contact.index');
});

Route::post('/confirm', [ContactController::class, 'confirm'])->name('contact.confirm');
Route::post('/thanks', [ContactController::class, 'store'])->name('contact.store');
Route::get('/thanks', [ContactController::class, 'thanks'])->name('contact.thanks');

// --- 2. 管理者用：認証必須ルート（authミドルウェア & /admin プレフィックス） ---
Route::middleware(['auth'])->prefix('admin')->group(function () {
    // お問い合わせ一覧・絞り込み検索
    Route::get('/', [AdminController::class, 'index'])->name('admin.index');

    // CSVエクスポート
    Route::get('/contacts/export', [ContactController::class, 'export'])->name('admin.export');

    // お問い合わせ詳細（モーダル表示用）
    Route::get('/contacts/{contact}', [AdminController::class, 'show'])->name('admin.show');

    // お問い合わせへのタグ紐付け更新
    Route::post('/contacts/{contact}/tags', [AdminController::class, 'updateTags'])->name('admin.updateTags');

    // お問い合わせ削除
    Route::delete('/contacts/{contact}', [AdminController::class, 'destroy'])->name('admin.destroy');

    // タグ管理（一覧・作成・更新・削除）
    Route::get('/tags', [TagController::class, 'index'])->name('admin.tags.index');
    Route::post('/tags', [TagController::class, 'store'])->name('admin.tags.store');
    Route::put('/tags/{tag}', [TagController::class, 'update'])->name('admin.tags.update');
    Route::delete('/tags/{tag}', [TagController::class, 'destroy'])->name('admin.tags.destroy');
});
