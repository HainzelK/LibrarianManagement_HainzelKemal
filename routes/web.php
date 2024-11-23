<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CdController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', function () {
    return view('welcome');
});

// Basic authenticated routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Debug route - can be removed in production
    Route::get('/check-roles', function () {
        return auth()->user() ? auth()->user()->roles : 'No user authenticated';
    });
});

// Librarian routes
Route::middleware(['auth', 'role:librarian'])->group(function () {
    // Reservations management
    Route::get('reservations', [ReservationController::class, 'index'])->name('reservations.index');
    Route::post('reservations/{id}/approve', [ReservationController::class, 'approve'])->name('reservations.approve');
    Route::post('reservations/{id}/reject', [ReservationController::class, 'reject'])->name('reservations.reject');
    
    // Books management
    Route::resource('books', BookController::class);
    
    // CDs management
    Route::resource('cds', CdController::class);
});

// Admin routes
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('admin/pending-books', [AdminController::class, 'index'])->name('admin.index');
    Route::post('admin/approve-book/{id}', [AdminController::class, 'approve'])->name('admin.approve');
    Route::post('admin/reject-book/{id}', [AdminController::class, 'reject'])->name('admin.reject');
    
    // User management routes
    Route::resource('admin/users', 'App\Http\Controllers\UserController');
});

// Authentication routes
require __DIR__.'/auth.php';
