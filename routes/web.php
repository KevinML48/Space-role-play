<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServerController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ChannelController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\SalonController;
use Illuminate\Support\Facades\Route;

// Routes publiques
Route::get('/', function () {
    return view('welcome');
});

// Routes authentifiées + vérifiées
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Profil utilisateur
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Routes Salons (ajout principal ici)
    Route::get('/salons', [SalonController::class, 'index'])->name('salons.index'); // <-- ROUTE AJOUTÉE
    Route::post('/salons', [SalonController::class, 'store'])->name('salons.store');
    Route::get('/salons/{salon}', [SalonController::class, 'show'])->name('salons.show');
});

// Routes administrateur
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    // Gestion serveurs
    Route::get('/servers/create', [ServerController::class, 'create'])->name('servers.create');
    Route::post('/servers', [ServerController::class, 'store'])->name('servers.store');
    Route::get('/servers/{server}/edit', [ServerController::class, 'edit'])->name('servers.edit');
    Route::put('/servers/{server}', [ServerController::class, 'update'])->name('servers.update');

    // Ajoute cette ligne si elle n'y est pas
    Route::delete('/servers/{server}', [ServerController::class, 'destroy'])->name('servers.destroy');

    // Gestion catégories
    Route::post('/servers/{server}/categories', [CategoryController::class, 'store'])->name('categories.store');

    // Gestion channels (si maintenu)
    Route::post('/categories/{category}/channels', [ChannelController::class, 'store'])->name('channels.store');
});



// Routes authentifiées générales
Route::middleware(['auth'])->group(function () {
    // Serveurs
    Route::get('/servers', [ServerController::class, 'index'])->name('servers.index');
    Route::get('/servers/{server}', [ServerController::class, 'show'])->name('servers.show');
    Route::post('/servers/join', [ServerController::class, 'join'])->name('servers.join');
    
    // Channels (si maintenus)
    Route::get('/channels/{channel}', [ChannelController::class, 'show'])->name('channels.show');
    
    // Messages
    Route::post('/channels/{channel}/messages', [MessageController::class, 'store'])->name('messages.store');
});

// Authentification
require __DIR__.'/auth.php';

// Fallback
Route::fallback(function () {
    return redirect('/dashboard');
});

// Route de test
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
