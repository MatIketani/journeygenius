<?php

use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Settings\SettingsController;
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

Route::get('/google/redirect', [GoogleController::class, 'redirect'])->name('google.redirect');

Route::get('/google/callback', [GoogleController::class, 'login'])->name('google.callback');
