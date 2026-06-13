<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;


Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::view('/admin/users', 'pages.admin.admin-users');
    Route::view('/admin/animals', 'pages.admin.admin-animals');
    Route::view('/admin/applications', 'pages.admin.admin-applications');
    Route::view('/admin/donations', 'pages.admin.admin-donations');
    Route::view('/admin/medicine', 'pages.admin.admin-medicine');
});

require __DIR__.'/settings.php';

Route::view('/gallery', 'pages.gallery');
Route::view('/auth/login', 'pages.auth.login');
Route::view('/login', 'pages.auth.login');
Route::view('/register', 'pages.auth.register');
Route::view('/profile', 'pages.profile');
Route::view('/', 'pages.index');
Route::view('/donations', 'pages.donations');
Route::view('/animal-profile', 'pages.animal-profile');
Route::view('/dashboard', 'pages.dashboard');

// valodas maiņas funkcija
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

Route::get('/lang/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'lv'])) {
        Session::put('locale', $locale);
    }
    return redirect()->back();
});

Volt::route('/', 'index');

Route::get('/', function () {
    return view('pages.index');
});

Route::get('/dashboard', function () {
    return view('pages.dashboard');
})->name('dashboard');