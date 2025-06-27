<?php

namespace App\Http\Controllers;

use App\Models\Chamado; // Importe o Model Chamado
use App\Models\Log;     // Importe o Model Log (ou o nome do seu Model de logs)
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Se precisar filtrar por usuário logado

class DashboardController extends Controller
{
    public function index()
    {
        // Contar Chamados Abertos
        $chamadosAbertos = Chamado::where('status', 'aberto')->count();

        // Contar Chamados Concluídos
        $chamadosConcluidos = Chamado::where('status', 'concluido')->count();

        // Contar Total de Histórico de Logs
        $totalLogs = Log::count(); // Isso conta todos os logs. Ajuste se precisar filtrar.

        return view('dashboard', compact('chamadosAbertos', 'chamadosConcluidos', 'totalLogs'));
    }
}