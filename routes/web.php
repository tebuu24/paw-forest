<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AnimalController;

Route::get('/', [AnimalController::class, 'home'])->name('home');


Route::get('/gallery', [AnimalController::class, 'index'])->name('gallery.index');
Route::get('/gallery/{id}', [AnimalController::class, 'show'])->name('gallery.show');

Route::view('/donations', 'pages.donations');

Route::get('/lang/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'lv'])) {
        session(['locale' => $locale]);
    }
    return redirect()->back();
});

Route::middleware(['auth'])->group(function () {
    
    Route::get('/profile', [UserController::class, 'show'])->name('profile');
    Route::put('/profile/update', [UserController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [UserController::class, 'updatePassword'])->name('profile.password');
    Route::delete('/profile/delete', [UserController::class, 'destroy'])->name('profile.delete');
    
    Route::middleware(['employee'])->group(function () {
        Route::view('/dashboard', 'pages.dashboard')->name('dashboard');
        Route::view('/admin/animals', 'pages.admin.admin-animals');
        Route::view('/admin/applications', 'pages.admin.admin-applications');
        Route::view('/admin/medicine', 'pages.admin.admin-medicine');
    });

    Route::middleware(['admin'])->group(function () {
        Route::get('/admin/users', [AdminController::class, 'index'])->name('admin.users.index');
        Route::view('/admin/donations', 'pages.admin.admin-donations');
        Route::view('/admin/locations', 'pages.admin.admin-locations');
    });
});

require __DIR__.'/settings.php';