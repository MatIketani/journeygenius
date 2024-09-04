<?php

use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Invitation\InvitationController;
use App\Http\Controllers\Settings\SettingsController;
use App\Http\Controllers\TravelPlans\TravelPlansController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::prefix('/settings')->controller(SettingsController::class)->group(function () {

        Route::get('/', 'index')->name('settings.index');

        Route::post('/confirm-changes', 'confirmChanges')->name('settings.confirm-changes');
    });
});

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['verify' => true]);

Route::prefix('/google')->controller(GoogleController::class)->group(function () {

    Route::get('/redirect', 'redirect')->name('google.redirect');

    Route::get('/callback', 'login')->name('google.callback');
});

Route::prefix('/invitation')->controller(InvitationController::class)->group(function () {

    Route::get('/register/{inviteCode}', 'registerByInvitation')->name('invitation.register');
});

Route::prefix('/travel-plans')->controller(TravelPlansController::class)->group(function () {

    Route::get('/create', 'create')->name('travel-plans.create');

    Route::post('/store', 'store')->name('travel-plans.store');
});
