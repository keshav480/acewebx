<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;

Route::middleware('guest')->group(function () {

    // Login
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AuthController::class, 'login']);

    // Register
    Route::get('register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [AuthController::class, 'register']);   
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
