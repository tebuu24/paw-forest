<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::view('/', 'pages.index')->name('home');
Route::view('/gallery', 'pages.gallery');
Route::view('/donations', 'pages.donations');
Route::view('/animal-profile', 'pages.animal-profile');

Route::get('/lang/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'lv'])) {
        session(['locale' => $locale]);
    }
    return redirect()->back();
});

Route::middleware(['auth'])->group(function () {
    Route::view('/profile', 'pages.profile')->name('profile');
    
    Route::middleware(['employee'])->group(function () {
        Route::view('/dashboard', 'pages.dashboard')->name('dashboard');
        Route::view('/admin/animals', 'pages.admin.admin-animals');
        Route::view('/admin/applications', 'pages.admin.admin-applications');
        Route::view('/admin/medicine', 'pages.admin.admin-medicine');
    });

    Route::middleware(['admin'])->group(function () {
        Route::view('/admin/donations', 'pages.admin.admin-donations');
        Route::view('/admin/users', 'pages.admin.admin-users');
    });
});

require __DIR__.'/settings.php';
Volt::route('/', 'index');

Route::get('/', function () {
    return view('pages.index');
});

Route::get('/dashboard', function () {
    return view('pages.dashboard');
})->name('dashboard');