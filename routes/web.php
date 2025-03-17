<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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

// Routes pour les administrateurs
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
    
    // Ajoutez ici d'autres routes admin si nécessaire
    // Par exemple :
    // Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
});

// Routes d'authentification (login, register, etc.)
require __DIR__.'/auth.php';

// Route de fallback (optionnelle)
Route::fallback(function () {
    return redirect('/dashboard');
});
