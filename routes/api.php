<?php

use App\Http\Controllers\Api\ProviderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\QuestionController;
use App\Http\Controllers\Api\ProviderAnswerController;
use App\Http\Controllers\Api\ProviderServiceController;
use App\Http\Controllers\Api\ProviderSubscriptionController;
use App\Http\Controllers\Api\TicketController;

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



Route::middleware(['auth:sanctum', 'locale'])->group(function () {
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

    Route::prefix('tickets')->group(function(){
        Route::get('/', [TicketController::class, 'index'])->name('tickets.index');
        Route::post('/', [TicketController::class, 'store'])->name('tickets.store');
        Route::get('/{ticket}', [TicketController::class, 'show'])->name('tickets.show');
        Route::post('/{ticket}/reply', [TicketController::class, 'reply'])->name('tickets.reply');
        Route::put('/{ticket}',[TicketController::class , 'update']);
        Route::delete('/{ticket}',[TicketController::class , 'destroy']);
    });



    // Provider APIs
    Route::prefix('provider')->middleware('checkProvider')->group(function () {

        Route::post('profile', [ProviderController::class, 'updateProfile'])->name('profile.update');


        // Questions API
        Route::prefix('questions')->group(function () {
            Route::get('/category/{id}', [QuestionController::class, 'indexByCategory'])->name('api.questions.index-by-category');
        });

        // Provider Answers API
        Route::post('/answers-question', [ProviderAnswerController::class, 'store'])->name('api.provider-answers.store');
        Route::get('/my-answers', [ProviderAnswerController::class, 'getMyAnswers'])->name('api.provider-answers.my-answers');

        // Provider Profile API
        Route::get('/profile', [ProviderController::class, 'profile'])->name('api.provider.profile');

        // Provider Services API
        Route::get('/provider-services', [ProviderServiceController::class, 'providerIndex'])->name('api.provider-services.index');
        Route::post('/provider-services', [ProviderServiceController::class, 'store'])->name('api.provider-services.store');
        Route::put('/provider-services/{id}', [ProviderServiceController::class, 'update'])->name('api.provider-services.update');
        Route::delete('/provider-services/{id}', [ProviderServiceController::class, 'destroy'])->name('api.provider-services.destroy');

        // Provider Subscriptions API
        Route::get('/provider-subscriptions', [ProviderSubscriptionController::class, 'index'])->name('api.provider-subscriptions.index');
        Route::post('/provider-subscriptions', [ProviderSubscriptionController::class, 'store'])->name('api.provider-subscriptions.store');
        Route::post('/provider-subscriptions/{id}/pay', [ProviderSubscriptionController::class, 'pay'])->name('api.provider-subscriptions.pay');
    });



});
