<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ImageUploadControleer;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// 記事挿入upload登録
Route::post('/imageUpload', [ImageUploadControleer::class, 'upload']);

Route::get('api/articles', [ArticleController::class, 'loadMore']);