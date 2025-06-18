<?php

namespace App\Http\Controllers;

use App\Models\Equipe;
use App\Models\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class EquipeController extends Controller
{
    /**
     * Exibe a lista de equipes.
     */
    public function index(): View
    {
        $equipes = Equipe::latest()->paginate(10);
        return view('equipes.index', compact('equipes'));
    }

    /**
     * Exibe o formulário para criar uma nova equipe.
     */
    public function create(): View
    {
        return view('equipes.create');
    }

    /**
     * Armazena uma nova equipe no banco de dados.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
        ]);

        $equipe = Equipe::create($validated);

        Log::create([
            'user_id' => Auth::id(),
            'acao' => 'Criou uma equipe',
            'detalhes' => 'Nome: ' . $equipe->nome,
        ]);

        return redirect()->route('equipes.index')->with('success', 'Equipe criada com sucesso!');
    }

    /**
     * Exibe os detalhes de uma equipe específica.
     */
    public function show(string $id): View
    {
        $equipe = Equipe::findOrFail($id);
        return view('equipes.show', compact('equipe'));
    }

    /**
     * Exibe o formulário para editar uma equipe específica.
     */
    public function edit(string $id): View
    {
        $equipe = Equipe::findOrFail($id);
        return view('equipes.edit', compact('equipe'));
    }

    /**
     * Atualiza os dados de uma equipe específica.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $equipe = Equipe::findOrFail($id);

        $validated = $request->validate([
            'nome' => 'required|string|max:255',
        ]);

        $equipe->update($validated);

        Log::create([
            'user_id' => Auth::id(),
            'acao' => 'Atualizou uma equipe',
            'detalhes' => 'Nome: ' . $equipe->nome,
        ]);

        return redirect()->route('equipes.index')->with('success', 'Equipe atualizada com sucesso!');
    }

    /**
     * Remove uma equipe do banco de dados.
     */
    public function destroy(string $id): RedirectResponse
    {
        $equipe = Equipe::findOrFail($id);
        $nome = $equipe->nome;

        $equipe->delete();

        Log::create([
            'user_id' => Auth::id(),
            'acao' => 'Excluiu uma equipe',
            'detalhes' => 'Nome: ' . $nome,
        ]);

        return redirect()->route('equipes.index')->with('success', 'Equipe removida com sucesso!');
    }
}
