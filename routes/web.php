<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\InboxController;
use App\Http\Controllers\Auth\DashboardController;
use App\Http\Controllers\Auth\BillingController;
use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\Auth\AccountController;
use App\Http\Controllers\Auth\AutomationController;
use App\Http\Controllers\Auth\TrainingController;
use App\Http\Controllers\Auth\OpenAIController;
use App\Http\Controllers\Auth\SocialLoginController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::redirect('/', 'login');

Auth::routes([
    'register' => false
]);

Route::prefix('auth')->as('auth.')->middleware(['auth'])->group(function() {
    Route::get('logout', [DashboardController::class, 'logout'])->name('logout');
    Route::get('dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

    Route::prefix('inbox')->as('inbox.')->controller(InboxController::class)->group(function() {
        Route::get('/', 'openInbox')->name('index');
        Route::get('details', 'openMailDetails')->name('details');
    });


    Route::prefix('billings')->as('billings.')->controller(BillingController::class)->group(function() {
        Route::get('/', 'openBillingPage')->name('index');
        Route::post('/', 'storeBillingInformation')->name('store');
        Route::get('success', 'openBillingSuccessPage')->name('success');
    });


    Route::prefix('profile')->as('profile.')->controller(ProfileController::class)->group(function() {
        Route::get('edit', 'editProfile')->name('edit');
        Route::post('update/{id}', 'updateProfile')->name('update');
    });

    Route::prefix('accounts')->as('accounts.')->controller(AccountController::class)->group(function() {
        Route::get('edit', 'editAccount')->name('edit');
        Route::post('update/{id}', 'updateAccount')->name('update');
    });

    Route::prefix('trainings')->as('trainings.')->controller(TrainingController::class)->group(function() {
        Route::get('/', 'editTraining')->name('edit');
        Route::patch('/update', 'updateTraining')->name('update');
        Route::delete('/response-training/delete/{id}', 'deleteResponseTraining')->name('response-training.delete');
        Route::delete('/links/delete/{id}', 'deleteLinks')->name('links.delete');
        // Route::post('update/{id}', 'updateAccount')->name('update');
    });

    Route::controller(OpenAIController::class)->group(function() {
        Route::get('open-ai', 'openHomePage')->name('open-ai.index');
        Route::post('open-ai/fetch', 'loadResponse')->name('open-ai.fetch');
    });

});

Route::get('clear', function() {

    session()->forget('access_token');

    return 'cleared';

});

// Route::get('google/integration', [SocialLoginController::class, 'openGoogleIntegrationPage'])->name('google.integration');
Route::get('google/login', [SocialLoginController::class, 'redirectToGoogle'])->name('google.login')->middleware('auth');
Route::get('google/redirect', [SocialLoginController::class, 'redirectGoogleAfterLogin'])->name('google.redirect');
Route::get('google/generate-refresh-token', [SocialLoginController::class, 'generateRefreshToken'])->name('google.generate.generate-refresh-token');


Route::get('webhook', [AutomationController::class, 'replyToReceivedMail'])->name('automation.email.reply');


Route::get('/home', function() {


    if (session()->has('access_token')) {

        dd('have access token');

    }

    else {

        return to_route('google.generate.generate-refresh-token');
        dd('do not have');

    }

})->name('user.home');
