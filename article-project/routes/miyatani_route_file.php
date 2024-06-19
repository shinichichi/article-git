<?php

use App\Http\Controllers\SearchController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\MypageController;
use Illuminate\Support\Facades\Route;


// 記事の作成
Route::get('/create', [ArticleController::class, 'create'])->name('article.create');
// 記事作成確認画面
Route::post('/create/posted_preference', [ArticleController::class, 'createPostedPreference'])->name('article.create.posted_preference');
// 作成処理
Route::get('/store', [ArticleController::class, 'store'])->name('article.store');
// 記事の編集画面
Route::get('/edit', [ArticleController::class, 'edit'])->name('article.edit');
// 記事編集確認画面
// Route::get('/edit/posted_preference', [ArticleController::class, 'editPostedPreference'])->name('article.edit.posted_preference');
Route::patch('/edit/posted_preference', [ArticleController::class, 'editPostedPreference'])->name('article.edit.posted_preference');
// 記事編集処理
Route::get('/update', [ArticleController::class, 'update'])->name('article.update');

// 記事にコメントを投稿
Route::post('/article/comment', [CommentController::class, 'commentAcquisition'])->name('article.comment');


Route::middleware('auth')->group(function () {
    Route::get('/mypage', [MypageController::class, 'show'])->name('mypage.show');
    Route::get('/mypage/comment_list',[MypageController::class, 'commentIndex'])->name('mypage.comment_list');
    Route::get('/mypage/good_list',[MypageController::class, 'goodIndex'])->name('mypage.good_list');

});
