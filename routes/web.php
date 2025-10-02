<?php

use App\Http\Controllers\Web\Dashboard\Auth\AuthController;
use App\Http\Controllers\Web\Dashboard\Auth\PasswordResetController;
use App\Http\Controllers\Web\Dashboard\Auth\ProfileController;
use App\Http\Controllers\Web\Dashboard\CategoryController;
use App\Http\Controllers\Web\Dashboard\DashboardController;
use App\Http\Controllers\Web\Dashboard\McqQuestionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::post('toggle-language', [DashboardController::class, 'toggleLanguage'])->name('toggle-language');

Route::prefix('admin')->middleware('guest')->group(function () {
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AuthController::class, 'login'])->name('login.submit');
    Route::get('forgot-password', [PasswordResetController::class, 'showForgotPasswordForm'])->name('forgot-password');
    Route::post('forgot-password', [PasswordResetController::class, 'sendResetLinkEmail'])->name('forgot-password.send');
    Route::get('reset-password/{token}', [PasswordResetController::class, 'showResetPasswordForm'])->name('reset-password');
    Route::post('reset-password', [PasswordResetController::class, 'resetPassword'])->name('reset-password.submit');
});

Route::prefix('admin')->as('admin.')->middleware('locale')->group(function () {


        Route::middleware(['auth'])->group(function () {
        Route::post('logout', [AuthController::class, 'logout'])->name('logout');
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Profile routes
        Route::get('profile', [ProfileController::class, 'showProfile'])->name('profile');
        Route::post('profile', [ProfileController::class, 'updateProfile'])->name('profile.update');
        Route::post('profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');

        // Categories routes
        Route::resource('categories', CategoryController::class);

        // MCQ Questions routes
        Route::resource('mcq-questions', McqQuestionController::class)->names('mcq-questions');
        Route::patch('mcq-questions/{mcqQuestion}/toggle-status', [McqQuestionController::class, 'toggleStatus'])->name('mcq-questions.toggle-status');
        Route::post('mcq-questions/update-sort-order', [McqQuestionController::class, 'updateSortOrder'])->name('mcq-questions.update-sort-order');
    });
});
