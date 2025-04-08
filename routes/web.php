<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServerController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ChannelController;
use App\Http\Controllers\MessageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SalonController;
use App\Http\Controllers\MessageController;

// Routes publiques
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
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
    
    Route::get('/servers/create', [ServerController::class, 'create'])->name('servers.create');
    Route::post('/servers', [ServerController::class, 'store'])->name('servers.store');
    Route::post('/servers/{server}/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::post('/categories/{category}/channels', [ChannelController::class, 'store'])->name('channels.store');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/servers', [ServerController::class, 'index'])->name('servers.index');
    Route::get('/servers/{server}', [ServerController::class, 'show'])->name('servers.show');
    Route::post('/servers/join', [ServerController::class, 'join'])->name('servers.join');
    Route::get('/channels/{channel}', [ChannelController::class, 'show'])->name('channels.show');
    Route::post('/channels/{channel}/messages', [MessageController::class, 'store'])->name('messages.store');
});


// Routes d'authentification
require __DIR__.'/auth.php';

// Route de fallback
Route::fallback(function () {
    return redirect('/dashboard');
});

Route::get('/test-auth', function () {
    $user = auth()->user();
    $roles = $user->roles->pluck('name');
    $isAdmin = $user->hasRole('admin');
    
    dd([
        'user' => $user,
        'roles' => $roles,
        'isAdmin' => $isAdmin
    ]);
});
