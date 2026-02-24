<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\admin\SettingController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\admin\MenuController;
use App\Http\Controllers\admin\PageController;

use App\Http\Controllers\public\PublicPageController;

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
    })->name('home');
    Route::get('/profile', function () {
    })->name('profile');

Route::prefix('ace-admin')->name('admin.')->middleware(['auth','admin'])->group(function() {
    Route::get('/', [DashboardController::class , 'index'])->name('dashboard');
    Route::get('/dashboard', function () {
        return view('admin.pages.dashboard');
    });
    // Users
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/{id}', [UserController::class, 'show'])->name('users.show');
    Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
    // Settings
    Route::get('/settings', [SettingController::class, 'index'])->name('settings');
    Route::post('/settings', [SettingController::class, 'store'])->name('settings.store');    

    Route::get('/menu', [MenuController::class, 'index'])->name('menu');   
    Route::post('/menu/store', [MenuController::class, 'store'])->name('menu.store');   
    Route::get('/menu/{id}', [MenuController::class, 'getMenu'])->name('menu.get');
    Route::delete('/menu/{id}', [MenuController::class, 'destroy'])->name('menu.delete');


    // Pages list
     Route::get('/pages/', [PageController::class, 'index'])->name('pages.index');
    Route::get('/pages/?search', [PageController::class, 'index'])->name('pages');
    // Create page form
    Route::get('/pages/create', [PageController::class, 'create'])->name('pages.create');
    // Store new page
    Route::post('/pages', [PageController::class, 'store'])->name('pages.store');
    // Edit page form
    Route::get('/pages/edit/{id}', [PageController::class, 'edit'])->name('pages.edit');
    // Update page
    Route::put('/pages/{id}', [PageController::class, 'update'])->name('pages.update');
    // Delete page
    Route::delete('/pages/{id}', [PageController::class, 'destroy'])->name('pages.destroy');
});

 Route::post('/logout', [AuthController::class, 'destroy'])->middleware('auth')->name('logout');
Route::get('/{slug}', [PublicPageController::class, 'show'])->name('page.show');