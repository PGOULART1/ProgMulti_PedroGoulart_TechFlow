<?php

namespace App\Http\Controllers;

use App\Models\Mensagem; // Importe o modelo Mensagem
use App\Models\Chamado;  // Importe o modelo Chamado (para o caso de atualizar o status)
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Importe a Facade Auth

class MensagemController extends Controller
{
    /**
     * Armazena uma nova mensagem no banco de dados.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validação dos dados da mensagem
        $request->validate([
            'chamado_id' => 'required|exists:chamados,id', // O chamado deve existir
            'mensagem' => 'required|string|max:1000',     // O conteúdo da mensagem é obrigatório
        ]);

        // Cria a nova mensagem
        Mensagem::create([
            'chamado_id' => $request->chamado_id,
            'user_id' => Auth::id(), // O usuário logado é o autor da mensagem
            'mensagem' => $request->mensagem,
        ]);

        // Opcional: Se uma nova mensagem é adicionada a um chamado que estava 'concluido',
        // você pode querer reabri-lo automaticamente para 'em andamento'.
        $chamado = Chamado::find($request->chamado_id);
        if ($chamado && $chamado->status === 'concluido') {
            $chamado->status = 'em andamento';
            $chamado->save();
            return back()->with('success', 'Mensagem enviada com sucesso! O chamado foi reaberto.');
        }

        return back()->with('success', 'Mensagem enviada com sucesso!');
    }
}
