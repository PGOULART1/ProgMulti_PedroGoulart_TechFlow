<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Equipe;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class EquipeUsuarioController extends Controller
{
    use AuthorizesRequests;

        public function edit()
    {
        $this->authorize('podeAtribuirEquipe', Equipe::class);
    
        $equipes = Equipe::all();
        $usuarios = User::whereNull('equipe_id')->get();

        return view('equipes.atribuir', compact('equipes', 'usuarios'));
    }

    public function update(Request $request)
    {
        $this->authorize('podeAtribuirEquipe', Equipe::class);

        $validated = $request->validate([
            'equipe_id' => 'required|exists:equipes,id',
            'usuarios' => 'array',
            'usuarios.*' => 'exists:users,id',
        ]);

        User::whereIn('id', $validated['usuarios'])->update(['equipe_id' => $validated['equipe_id']]);

        return redirect()->route('dashboard')->with('success', 'Usuários atribuídos com sucesso!');
    }
}
