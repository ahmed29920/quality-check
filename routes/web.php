<?php

use App\Http\Controllers\Web\Dashboard\Auth\AuthController;
use App\Http\Controllers\Web\Dashboard\Auth\PasswordResetController;
use App\Http\Controllers\Web\Dashboard\Auth\ProfileController;
use App\Http\Controllers\Web\Dashboard\BadgeController;
use App\Http\Controllers\Web\Dashboard\CategoryController;
use App\Http\Controllers\Web\Dashboard\DashboardController;
use App\Http\Controllers\Web\Dashboard\McqQuestionController;
use App\Http\Controllers\Web\Dashboard\ProviderController;
use App\Http\Controllers\Web\Dashboard\ProviderServiceController;
use App\Http\Controllers\Web\Dashboard\ProviderSubscriptionController;
use App\Http\Controllers\Web\Dashboard\RoleController;
use App\Http\Controllers\Web\Dashboard\PermissionController;
use App\Http\Controllers\Web\Dashboard\ServiceController;
use App\Http\Controllers\Web\Dashboard\SettingController;
use App\Http\Controllers\Web\Dashboard\UserController;
use App\Http\Controllers\Web\Dashboard\AdminController;
use App\Http\Controllers\Web\Dashboard\TicketController;
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
        Route::resource('mcq-questions', McqQuestionController::class);
        Route::patch('mcq-questions/{mcqQuestion}/toggle-status', [McqQuestionController::class, 'toggleStatus'])->name('mcq-questions.toggle-status');
        Route::post('mcq-questions/update-sort-order', [McqQuestionController::class, 'updateSortOrder'])->name('mcq-questions.update-sort-order');

        // Badges routes
        Route::resource('badges', BadgeController::class)->except('create', 'edit');


        // Services routes
        Route::PUT('services/{service}/restore', [ServiceController::class, 'restore'])->name('services.restore');
        Route::delete('services/{service}/force-delete', [ServiceController::class, 'forceDelete'])->name('services.force-delete');
        Route::resource('services', ServiceController::class);
        Route::post('services/filter', [ServiceController::class, 'filter'])->name('services.filter');

        // Users routes
        Route::get('/users/filter', [UserController::class, 'filter'])->name('users.filter');
        Route::resource('users', UserController::class)->only(['index', 'show', 'destroy']);
        Route::post('users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');

        // Admins routes
        Route::resource('admins', AdminController::class);

        // Providers routes
        Route::get('providers', [ProviderController::class, 'index'])->name('providers.index');
        Route::get('providers/filter', [ProviderController::class, 'filter'])->name('providers.filter');
        Route::get('providers/{provider}', [ProviderController::class, 'show'])->name('providers.show');
        Route::get('providers/{provider}/edit', [ProviderController::class, 'edit'])->name('providers.edit');
        Route::put('providers/{provider}', [ProviderController::class, 'update'])->name('providers.update');
        Route::post('providers/{provider}/toggle-status', [ProviderController::class, 'toggleStatus'])->name('providers.toggle-status');
        Route::post('providers/{provider}/toggle-verification', [ProviderController::class, 'toggleVerification'])->name('providers.toggle-verification');
        Route::post('providers/{provider}/answers/{answer}/evaluate', [ProviderController::class, 'evaluateAnswer'])->name('providers.answers.evaluate');

        // Provider services routes
        Route::get('provider-services', [ProviderServiceController::class, 'index'])->name('provider-services.index');
        Route::get('provider-services/filter', [ProviderServiceController::class, 'filter'])->name('provider-services.filter');
        Route::get('provider-services/create', [ProviderServiceController::class, 'create'])->name('provider-services.create');
        Route::get('provider-services/{providerService}', [ProviderServiceController::class, 'show'])->name('provider-services.show');
        Route::get('provider-services/{providerService}/edit', [ProviderServiceController::class, 'edit'])->name('provider-services.edit');
        Route::post('provider-services', [ProviderServiceController::class, 'store'])->name('provider-services.store');
        Route::put('provider-services/{providerService}', [ProviderServiceController::class, 'update'])->name('provider-services.update');
        Route::post('provider-services/{providerService}/toggle-status', [ProviderServiceController::class, 'toggleStatus'])->name('provider-services.toggle-status');
        Route::delete('provider-services/{providerService}', [ProviderServiceController::class, 'destroy'])->name('provider-services.destroy');

        // Provider subscriptions routes
        Route::get('provider-subscriptions', [ProviderSubscriptionController::class, 'index'])->name('provider-subscriptions.index');
        Route::post('provider-subscriptions/filter', [ProviderSubscriptionController::class, 'filter'])->name('provider-subscriptions.filter');
        Route::get('provider-subscriptions/{providerSubscription}', [ProviderSubscriptionController::class, 'show'])->name('provider-subscriptions.show');

        // Settings routes
        Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
        Route::put('settings', [SettingController::class, 'update'])->name('settings.update');

        // Tickets routes
        Route::get('/tickets', [TicketController::class, 'index'])->name('tickets.index');
        Route::get('/tickets/filter', [TicketController::class, 'filter'])->name('tickets.filter');
        Route::get('/tickets/{id}', [TicketController::class, 'show'])->name('tickets.show');
        Route::post('/tickets/{id}/reply', [TicketController::class, 'reply'])->name('tickets.reply');
        Route::patch('/tickets/{id}/status', [TicketController::class, 'changeStatus'])->name('tickets.changeStatus');

        Route::resource('roles', RoleController::class);

        Route::resource('permissions', PermissionController::class);
    });
});
