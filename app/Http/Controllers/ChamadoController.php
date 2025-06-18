<?php

namespace App\Http\Controllers;

use App\Models\Chamado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\Equipe;
use App\Models\Log;

class ChamadoController extends Controller
{
    use AuthorizesRequests;

    /**
     * Exibe a lista de chamados do usuário.
     *
     * @return View
     */
    public function index(): View
    {
        if (Auth::user()->role === 'tecnica') {
            // Técnicos veem todos os chamados com a equipe relacionada
            $chamados = Chamado::with('equipe')->latest()->paginate(10);
        } else {
            // Usuários comuns veem apenas seus próprios chamados com a equipe relacionada
            $chamados = Chamado::with('equipe')
                ->where('user_id', Auth::id())
                ->latest()
                ->paginate(10);
        }

        return view('chamados.index', compact('chamados'));
    }

    /**
     * Exibe o formulário para criar um novo chamado.
     *
     * @return View
     */
    public function create(): View
    {
        $equipes = Equipe::all(); // Busca todas as equipes
        return view('chamados.create', compact('equipes'));
    }

    /**
     * Salva um novo chamado no banco de dados.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'required|string',
            'prioridade' => 'required|in:baixa,media,alta',
            'equipe_id' => 'nullable|exists:equipes,id',
        ]);

        // Captura o chamado criado para uso posterior no log
        $chamado = Chamado::create([
            'user_id' => Auth::id(),
            'titulo' => $validated['titulo'],
            'descricao' => $validated['descricao'],
            'prioridade' => $validated['prioridade'],
            'equipe_id' => $validated['equipe_id'] ?? null,
            'status' => 'aberto',
        ]);

        Log::create([
            'user_id' => auth()->id(),
            'acao' => 'Criou um chamado',
            'detalhes' => 'Título: ' . $chamado->titulo,
        ]);

        return redirect()->route('chamados.index')->with('success', 'Chamado criado com sucesso!');
    }

    /**
     * Exibe os detalhes de um chamado específico.
     *
     * @param Chamado $chamado
     * @return View
     */
    public function show(Chamado $chamado): View
    {
        $this->authorize('view', $chamado);

        return view('chamados.show', compact('chamado'));
    }

    /**
     * Exibe o formulário de edição de um chamado específico.
     *
     * @param Chamado $chamado
     * @return View
     */
    public function edit(Chamado $chamado): View
    {
        $this->authorize('update', $chamado);

        $equipes = Equipe::all();

        return view('chamados.edit', compact('chamado', 'equipes'));
    }

    /**
     * Atualiza o recurso especificado no armazenamento.
     *
     * @param Request $request
     * @param Chamado $chamado
     * @return RedirectResponse
     */
    public function update(Request $request, Chamado $chamado): RedirectResponse
    {
        $this->authorize('update', $chamado);

        $rules = [
            'titulo' => 'required|string|max:255',
            'descricao' => 'required|string',
            'prioridade' => 'required|in:baixa,media,alta',
            'status' => 'required|in:aberto,em andamento,resolvido,fechado',
            'equipe_id' => 'nullable|exists:equipes,id',
        ];

        if (Auth::user()->role !== 'tecnica') {
            $rules['prioridade'] = [
                'required',
                Rule::in([$chamado->prioridade]),
            ];
            $rules['status'] = [
                'required',
                Rule::in([$chamado->status]),
            ];
        }

        $validated = $request->validate($rules);

        $chamado->update($validated);

        Log::create([
            'user_id' => auth()->id(),
            'acao' => 'Atualizou um chamado',
            'detalhes' => 'Título: ' . $chamado->titulo,
        ]);

        return redirect()->route('chamados.index')->with('success', 'Chamado atualizado com sucesso!');
    }

    /**
     * Remove o recurso especificado do armazenamento.
     *
     * @param Chamado $chamado
     * @return RedirectResponse
     */
    public function destroy(Chamado $chamado): RedirectResponse
    {
        $this->authorize('delete', $chamado);

        // Captura título antes de deletar para registrar no log
        $titulo = $chamado->titulo;
        $chamado->delete();

        Log::create([
            'user_id' => auth()->id(),
            'acao' => 'Excluiu um chamado',
            'detalhes' => 'Título: ' . $titulo,
        ]);

        return redirect()->route('chamados.index')->with('success', 'Chamado excluído com sucesso!');
    }
}
