<?php

use App\Http\Controllers\SearchController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\MypageController;
use Illuminate\Support\Facades\Route;


// Route::get('/index', [ArticleController::class, 'index'])->name('article.index')->middleware('auth');
Route::get('/create', [ArticleController::class, 'create'])->name('article.create');

// Route::post('/show', [ArticleController::class, 'show'])->name('article.show');
Route::post('/create/posted_preference', [ArticleController::class, 'createPostedPreference'])->name('article.create.posted_preference');
Route::get('/store', [ArticleController::class, 'store'])->name('article.store');

Route::post('/edit', [ArticleController::class, 'edit'])->name('article.edit');
Route::get('/edit/posted_preference', [ArticleController::class, 'editPostedPreference'])->name('article.edit.posted_preference');
Route::patch('/edit/posted_preference', [ArticleController::class, 'editPostedPreference'])->name('article.edit.posted_preference');
Route::get('/update', [ArticleController::class, 'update'])->name('article.update');

// comment
Route::post('/article/comment', [CommentController::class, 'commentAcquisition'])->name('article.comment');


Route::middleware('auth')->group(function () {
    Route::get('/mypage', [MypageController::class, 'show'])->name('mypage.show');
    Route::get('/mypage/comment_list',[MypageController::class, 'commentIndex'])->name('mypage.comment_list');
    Route::get('/mypage/good_list',[MypageController::class, 'goodIndex'])->name('mypage.good_list');

});
