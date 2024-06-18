<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register');

    //　会員登録確認
    Route::post('/register/user/info/input/conf', [RegisteredUserController::class, 'show'])
        ->name('auth.show');

    // 会員登録
    Route::post('register', [RegisteredUserController::class, 'store'])
        ->name('register');

    // トークン認証
    Route::post('authregister', [RegisteredUserController::class, 'auth'])
        ->name('authregister');

    /**
     ** 新規会員登録画面前の最初のメール入力画面を表示するルーティング
     */
    Route::get('first-auth', [RegisteredUserController::class, 'sendPassEmail'])
        ->name('auth.first-auth'); // 追加

    /**
     **トークンを含んだメールを送信するルーティング
     */
    Route::post('sendTokenEmail', [RegisteredUserController::class, 'sendTokenEmail'])
        ->name('sendTokenEmail');

    // ログイン入力
    Route::get('login', [AuthenticatedSessionController::class, 'create'])
                ->name('login');

    // ログイン認証
    Route::post('login', [AuthenticatedSessionController::class, 'store'])
        ->name('login'); //追加

    // パスワードリセット
    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
                ->name('password.request');
    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
                ->name('password.email');
    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
                ->name('password.reset');
    Route::post('reset-password', [NewPasswordController::class, 'store'])
                ->name('password.store');
});

Route::middleware('auth')->group(function () {
    Route::get('verify-email', EmailVerificationPromptController::class)
                ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
                ->middleware(['signed', 'throttle:6,1'])
                ->name('verification.verify');
                
    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
                ->middleware('throttle:6,1')
                ->name('verification.send');

    // アイコン画像更新
    Route::patch('', [ProfileController::class, 'iconchange'])
        ->name('iconchange');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
                ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('password', [PasswordController::class, 'update'])->name('password.update');
    
    //　ログアウト
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
                ->name('logout');
});
