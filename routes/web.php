<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;



Route::middleware('guest')->group(function () {

    // Login
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login']);

    // Register
    Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [RegisterController::class, 'register']);

});

// Public Home
Route::get('/', function () {
    return view('public.pages.home');
});

Route::prefix('ace-admin')->name('admin.')->middleware('auth')->group(function() {
    Route::get('/', function () {
        return view('admin.pages.dashboard');
    })->name('dashboard');

    Route::get('/dashboard', function () {
        return view('admin.pages.dashboard');
    });

    // Users
    Route::get('/users', function () {
        return view('admin.pages.users');
    })->name('users.index');

    // Settings
    Route::get('/settings', function () {
        return view('admin.pages.settings');
    })->name('settings');

    // Profile
    Route::get('/profile', function () {
        return view('admin.pages.profile');
    })->name('profile');
 
});
