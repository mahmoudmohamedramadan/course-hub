<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;

Route::middleware('guest')->group(function () {
    Route::controller(RegisteredUserController::class)
        ->prefix('register')
        ->group(function () {
            Route::get('/',  'create')->name('register');
            Route::post('/', 'store');
        });

    Route::controller(AuthenticatedSessionController::class)
        ->prefix('login')
        ->group(function () {
            Route::get('/',  'create')->name('login');
            Route::post('/', 'store');
        });

    Route::controller(PasswordResetLinkController::class)
        ->prefix('forgot-password')
        ->group(function () {
            Route::get('/',  'create')->name('password.request');
            Route::post('/', 'store')->name('password.email');
        });

    Route::controller(NewPasswordController::class)
        ->prefix('reset-password')
        ->group(function () {
            Route::get('/{token}',  'create')->name('password.reset');
            Route::post('/',        'store')->name('password.store');
        });
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

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});
