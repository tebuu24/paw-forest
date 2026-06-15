<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AnimalController;
use App\Http\Controllers\AdoptionController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\VisitController;
use App\Http\Controllers\DonationController;

// Public routes
Route::get('/', [AnimalController::class, 'home'])->name('home');
Route::get('/gallery', [AnimalController::class, 'index'])->name('gallery.index');
Route::get('/gallery/{id}', [AnimalController::class, 'show'])->name('gallery.show');

Route::get('/donations', [DonationController::class, 'create'])->name('donations.create');
Route::post('/donations', [DonationController::class, 'store'])->name('donations.store');

// Language Switcher
Route::get('/lang/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'lv'])) {
        session(['locale' => $locale]);
    }
    return redirect()->back();
});

// Authenticated Session Routes
Route::middleware(['auth'])->group(function () {
    
    // Regular User Profile Management
    Route::get('/profile', [UserController::class, 'show'])->name('profile.show');
    Route::put('/profile/update', [UserController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [UserController::class, 'updatePassword'])->name('profile.password');
    Route::delete('/profile/delete', [UserController::class, 'destroy'])->name('profile.delete');
    Route::post('/visits', [VisitController::class, 'store'])->name('visits.store');
    Route::post('/adoptions', [AdoptionController::class, 'store'])->name('adoptions.store');
    
    // Employee & Admin Shared Routes
    Route::middleware(['employee'])->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        
        // Animal Standard Management
        Route::get('/admin/animals', [AnimalController::class, 'adminIndex'])->name('animals.index');
        Route::get('/admin/animals/create', [AnimalController::class, 'create'])->name('animals.create');
        Route::post('/admin/animals', [AnimalController::class, 'store'])->name('animals.store');
        Route::get('/admin/animals/{id}/edit', [AnimalController::class, 'edit'])->name('animals.edit');
        Route::put('/admin/animals/{id}', [AnimalController::class, 'update'])->name('animals.update');
        Route::delete('/admin/animals/{id}', [AnimalController::class, 'destroy'])->name('animals.destroy');
        Route::post('/admin/animals/{id}/restore', [AnimalController::class, 'restore'])->name('animals.restore');

        // Applications / Adoptions
        Route::view('/admin/applications', 'pages.admin.admin-applications');
        Route::patch('/admin/applications/{id}/approve', [AdoptionController::class, 'approve']);
        Route::patch('/admin/applications/{id}/reject', [AdoptionController::class, 'reject']);
        Route::delete('/admin/applications/{id}', [AdoptionController::class, 'destroy']);
        Route::post('/admin/applications/{id}/restore', [AdoptionController::class, 'restore']);

        // Shelter Visits Shared Actions
        Route::patch('/admin/visits/{id}/approve', [VisitController::class, 'approve']);
        Route::patch('/admin/visits/{id}/reject', [VisitController::class, 'reject']);
        Route::delete('/admin/visits/{id}', [VisitController::class, 'destroy']); 
        Route::post('/admin/visits/{id}/restore', [VisitController::class, 'restore']); 
        
        // Medicine Management
        Route::get('/admin/medicine', [MedicineController::class, 'index'])->name('medicine.index');
        Route::post('/admin/medicine', [MedicineController::class, 'store'])->name('medicine.store');
        Route::get('/admin/medicine/{id}/edit', [MedicineController::class, 'edit'])->name('medicine.edit');
        Route::put('/admin/medicine/{id}', [MedicineController::class, 'update'])->name('medicine.update');
        Route::delete('/admin/medicine/{id}', [MedicineController::class, 'destroy'])->name('medicine.destroy');
        Route::post('/admin/medicine/{id}/restore', [MedicineController::class, 'restore'])->name('medicine.restore');

        // Locations (Read view accessible to employee)
        Route::view('/admin/locations', 'pages.admin.admin-locations');

        // Employees can manage basic user status
        Route::get('/admin/users', [AdminController::class, 'index'])->name('admin.users.index');
        Route::post('/admin/users/{id}/block', [AdminController::class, 'block']);
        Route::delete('/admin/users/{id}', [UserController::class, 'destroy']);
        Route::post('/admin/users/{id}/restore', [UserController::class, 'restore']);
        Route::put('/admin/users/{id}', [UserController::class, 'adminUpdate']);
    });

    // Admin-Only Exclusive Routes
    Route::middleware(['admin'])->group(function () {
        // Administrative Animal Actions
        Route::delete('/admin/animals/{id}/force-delete', [AnimalController::class, 'forceDelete'])->name('animals.forceDelete');

        // Administrative Application Actions
        Route::delete('/admin/applications/{id}/force-delete', [AdoptionController::class, 'forceDelete']);

        // Administrative Visit Actions
        Route::delete('/admin/visits/{id}/force-delete', [VisitController::class, 'forceDelete']); 

        // Administrative Location Management with Soft Delete support
        Route::get('/admin/locations/{id}/edit', function($id) {
            $location = \App\Models\Location::withTrashed()->findOrFail($id);
            return view('pages.admin.locations-edit', compact('location'));
        });
        Route::put('/admin/locations/{id}', [LocationController::class, 'update']);
        Route::post('/admin/locations', function() {
            $data = request()->validate([
                'name' => 'required|string',
                'address' => 'required|string'
            ]);
            \App\Models\Location::create($data);
            return redirect()->back()->with('status', __('Location created successfully!'));
        });
        Route::delete('/admin/locations/{id}', function($id) {
            \App\Models\Location::findOrFail($id)->delete();
            return redirect('/admin/locations')->with('status', __('Location removed from system.'));
        });
        Route::post('/admin/locations/{id}/restore', function($id) {
            \App\Models\Location::withTrashed()->findOrFail($id)->restore();
            return redirect()->back()->with('status', __('Location restored successfully!'));
        });

        // Only Admin can permanently wipe a user
        Route::delete('/admin/users/{id}/force-delete', [UserController::class, 'forceDelete']);

        // Administrative Donations System 
        Route::view('/admin/donations', 'pages.admin.admin-donations');
        Route::get('/admin/donations/{id}/edit', [DonationController::class, 'edit']);
        Route::put('/admin/donations/{id}', [DonationController::class, 'update']);
        Route::get('/admin/donations', [DonationController::class, 'index'])->name('admin.donations.index');
        Route::get('/admin/donations/{id}', [DonationController::class, 'show'])->name('admin.donations.show');
        Route::delete('/admin/donations/{id}', [DonationController::class, 'destroy']);
        Route::post('/admin/donations/{id}/restore', [DonationController::class, 'restore']);
    });
});

require __DIR__.'/settings.php';