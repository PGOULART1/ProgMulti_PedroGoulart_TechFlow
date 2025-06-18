<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChamadoController;
use App\Http\Controllers\EquipeController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\EquipeUsuarioController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('chamados', ChamadoController::class);
    Route::resource('equipes', EquipeController::class);
    

    
});

Route::middleware(['auth'])->group(function () {
    Route::get('/logs', [LogController::class, 'index'])->name('logs.index');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/atribuir-usuarios', [EquipeUsuarioController::class, 'edit'])->name('equipes.usuarios.edit');
    Route::post('/atribuir-usuarios', [EquipeUsuarioController::class, 'update'])->name('equipes.usuarios.update');
});

Route::get('/atribuir-usuarios', [EquipeController::class, 'atribuirUsuariosForm'])
    ->middleware('auth')
    ->name('equipes.atribuir');

require __DIR__.'/auth.php';
