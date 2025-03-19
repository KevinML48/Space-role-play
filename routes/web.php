<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SalonController;
use App\Http\Controllers\MessageController;

// Route publique
Route::get('/', function () {
    return view('welcome');
});

// Routes pour tous les utilisateurs authentifiés
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        $salons = \App\Models\Salon::with('messages.user')->get();
        return view('admin.dashboard', compact('salons'));
    })->name('admin.dashboard');

    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::post('/salons', [SalonController::class, 'store'])->name('salons.store');
});


Route::post('/messages', [MessageController::class, 'store']);
Route::post('/messages', [MessageController::class, 'store'])->name('messages.store')->middleware('auth');

// Routes pour les catégories
Route::resource('categories', CategoryController::class)->middleware('auth');

// Routes pour les salons
Route::resource('salons', SalonController::class)->middleware('auth');

// Routes d'authentification (login, register, etc.)
require __DIR__.'/auth.php';

// Route de fallback (optionnelle)
Route::fallback(function () {
    return redirect('/dashboard');
});
