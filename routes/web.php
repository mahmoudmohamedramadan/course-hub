<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CourseEnrollmentController;
use App\Http\Controllers\DashboardController;

Route::view('/', 'home')->name('home');

Route::prefix('courses')
    ->name('courses.')
    ->controller(CourseController::class)
    ->group(function () {
        Route::get('/',         'index')->name('index');
        Route::get('/{course}', 'show')->name('show');
    });

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')
    ->prefix('profile')
    ->name('profile.')
    ->controller(ProfileController::class)
    ->group(function () {
        Route::get('/',    'edit')->name('edit');
        Route::patch('/',  'update')->name('update');
        Route::delete('/', 'destroy')->name('destroy');
    });

Route::middleware(['auth', 'verified'])->group(function () {
    Route::post('/courses/{course}/enroll', [CourseEnrollmentController::class, 'store'])
        ->name('courses.enroll');
    Route::get('/courses/{course}/lessons/{lesson}', [LessonController::class, 'show'])
        ->scopeBindings()
        ->name('courses.lessons.show');
});
