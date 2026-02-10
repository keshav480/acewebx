<?php

use Illuminate\Support\Facades\Route;

// Public Home
Route::get('/', function () {
    return view('public.pages.home');
});

// Admin Routes
Route::prefix('ace-admin')->name('admin.')->group(function() {
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
