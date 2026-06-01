<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PosController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('pos.index');
    }
    return redirect()->route('login');
});

// Tableau de bord par défaut de Laravel Breeze (Optionnel, gardé pour compatibilité)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| Routes d'Authentification Profil (Breeze)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Application POS (Gestion de la Brasserie)
|--------------------------------------------------------------------------
| Toutes ces routes nécessitent d'être connecté via le middleware 'auth'.
| Elles sont préfixées par '/pos' (ex: /pos, /pos/sync, /pos/category/1)
*/
Route::middleware(['auth'])->prefix('pos')->name('pos.')->group(function () {
    
    // Écran 1 : Grille Bento des catégories principale
    Route::get('/', [PosController::class, 'index'])->name('index');
    
    // Écran 2 : Formats, tarifs et suppléments d'une catégorie
    Route::get('/category/{category}', [PosController::class, 'show'])->name('show');
    
    // API Temps Réel : Pousse l'état du panier à l'écran meuble à chaque clic
    Route::post('/sync', [PosController::class, 'syncCart'])->name('sync');
    
    // API Validation : Enregistre le ticket en base de données et vide les écrans
    Route::post('/validate', [PosController::class, 'store'])->name('validate');
    
});

// Inclusion des routes d'authentification Breeze (Login, Register, Logout...)
require __DIR__.'/auth.php';