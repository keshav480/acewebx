<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\admin\SettingController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\UserController;


Route::middleware('guest')->group(function () {

    // Login
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AuthController::class, 'login']);

    // Register
    Route::get('register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [AuthController::class, 'register']);   
    
    Route::get('/cancel-otp', [AuthController::class, 'cancelOtp'])->name('cancel.otp');
});

// Public Home
Route::get('/', function () {
    return view('public.pages.home');
});

Route::prefix('ace-admin')->name('admin.')->middleware(['auth','admin'])->group(function() {
    Route::get('/', function () {
        return view('admin.pages.dashboard');
    })->name('dashboard');

    Route::get('/dashboard', function () {
        return view('admin.pages.dashboard');
    });

    // Users
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/{id}', [UserController::class, 'show'])->name('users.show');
    Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');

     // Profile
    Route::get('/profile', function () {return view('admin.pages.profile');})->name('profile');
    // Settings
    Route::get('/settings', [SettingController::class, 'index'])->name('settings');
    Route::post('/settings', [SettingController::class, 'store'])->name('settings.store');    
   
   
});
 Route::post('/logout', [AuthController::class, 'destroy'])->middleware('auth')->name('logout');