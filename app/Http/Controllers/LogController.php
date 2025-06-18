<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Log; // Certifique-se que tem o model Log criado

class LogController extends Controller
{
    public function index()
    {
        // Buscar logs ordenados do mais recente para o mais antigo
        $logs = Log::orderBy('created_at', 'desc')->paginate(20);

        // Retornar a view logs.index (que você deve criar) passando os logs
        return view('logs.index', compact('logs'));
    }
}
