<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChamadoController;
use App\Http\Controllers\EquipeController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\EquipeUsuarioController;
use App\Http\Controllers\MensagemController;
use App\Http\Controllers\AnexoController;
use App\Http\Controllers\DashboardController;



Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Agrupamento de rotas que exigem autenticação
Route::middleware('auth')->group(function () {
    // Rotas de Perfil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rotas de Logs
    Route::get('/logs', [LogController::class, 'index'])->name('logs.index');

    // Rotas de Atribuição de Usuários a Equipes
    Route::get('/atribuir-usuarios', [EquipeUsuarioController::class, 'edit'])->name('equipes.usuarios.edit');
    Route::post('/atribuir-usuarios', [EquipeUsuarioController::class, 'update'])->name('equipes.usuarios.update');
    // Esta rota parece ser duplicada ou uma alternativa, mantendo-a por enquanto se for usada.
    Route::get('/atribuir-usuarios', [EquipeController::class, 'atribuirUsuariosForm'])->name('equipes.atribuir');

    // Rotas para Mensagens (usando MensagemController para armazenar)
    Route::post('/mensagens', [MensagemController::class, 'store'])->name('mensagens.store');

    // Rotas Específicas para Chamados (devem vir antes do Route::resource('chamados'))
    // Rota para Listar Chamados Concluídos
    Route::get('/chamados/concluidos', [ChamadoController::class, 'concluidos'])->name('chamados.concluidos');

    // Rota para Fechar um Chamado
    Route::put('/chamados/{chamado}/close', [ChamadoController::class, 'close'])->name('chamados.close');

    // Rota para Adicionar Anexo a um Chamado Específico (NOVA LINHA)
    Route::post('/chamados/{chamado}/anexos', [ChamadoController::class, 'adicionarAnexo'])->name('chamados.anexos.store');

    // Rotas de Recurso para Chamados (vem DEPOIS das rotas específicas para 'chamados/')
    Route::resource('chamados', ChamadoController::class);

    // Rotas de Recurso para Equipes
    Route::resource('equipes', EquipeController::class);

    Route::get('/anexos/{anexo}', [AnexoController::class, 'show'])->name('anexos.show');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

// Inclui as rotas de autenticação (login, register, etc.) que vem com o Laravel Breeze/UI
require __DIR__.'/auth.php';

