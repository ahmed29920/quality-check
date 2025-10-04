<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\AuthController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');



Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register'])->name('api.auth.register');
    Route::post('/login', [AuthController::class, 'login'])->name('api.auth.login');
    Route::post('/verify-phone', [AuthController::class, 'verifyPhone'])->name('api.auth.verify-phone');
    Route::post('/resend-phone-verification', [AuthController::class, 'resendPhoneVerification'])->name('api.auth.resend-phone-verification');
    Route::post('/send-password-reset', [AuthController::class, 'sendPasswordReset'])->name('api.auth.send-password-reset');
    Route::post('/verify-reset-code', [AuthController::class, 'verifyResetCode'])->name('api.auth.verify-reset-code');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('api.auth.reset-password');
});



Route::middleware('auth:sanctum')->group(function () {
    // Authentication APIs
    Route::prefix('auth')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout'])->name('api.auth.logout');
        Route::post('/change-password', [AuthController::class, 'changePassword'])->name('api.auth.change-password');
        Route::put('/profile', [AuthController::class, 'updateProfile'])->name('api.auth.update-profile');
        Route::get('/me', [AuthController::class, 'me'])->name('api.auth.me');
    });
    
    
    // Categories API
    Route::prefix('categories')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('api.categories.index');
        Route::get('/{id}', [CategoryController::class, 'show'])->name('api.categories.show');
    });
    
    // Services API
    Route::prefix('services')->group(function () {
        Route::get('/', [ServiceController::class, 'index'])->name('api.services.index');
        Route::get('/{id}', [ServiceController::class, 'show'])->name('api.services.show');
    });
});
