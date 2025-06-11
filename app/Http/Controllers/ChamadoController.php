<?php

namespace App\Http\Controllers;

use App\Models\Chamado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect; // Pode remover se usar redirect()->route
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rule; // Importar Rule para validação condicional
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

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
        // Se você quiser que o técnico veja TODOS os chamados, pode ajustar aqui:
        if (Auth::user()->role === 'tecnica') {
            $chamados = Chamado::latest()->paginate(10);
        } else {
            $chamados = Chamado::where('user_id', Auth::id())->latest()->paginate(10);
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
        return view('chamados.create');
    }

    /**
     * Salva um novo chamado no banco de dados.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([ // Use $validated para pegar os dados validados
            'titulo' => 'required|string|max:255',
            'descricao' => 'required|string',
            'prioridade' => 'required|in:baixa,media,alta',
        ]);

        Chamado::create([
            'user_id' => Auth::id(),
            'titulo' => $validated['titulo'], // Use $validated
            'descricao' => $validated['descricao'], // Use $validated
            'prioridade' => $validated['prioridade'], // Use $validated
            'status' => 'aberto', // **IMPORTANTE: Defina um status inicial aqui**
        ]);

        return redirect()->route('chamados.index')->with('success', 'Chamado criado com sucesso!'); // Redireciona para a lista de chamados
    }

    /**
     * Exibe os detalhes de um chamado específico.
     *
     * @param Chamado $chamado
     * @return View
     */
    public function show(Chamado $chamado): View
    {
        // Usa a policy 'view'. Se o usuário não puder ver, ele lança um 403.
        $this->authorize('view', $chamado); // A Lógica de Autorização está aqui!

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
        // Usa a policy 'update'. Se o usuário não puder editar, ele lança um 403.
        $this->authorize('update', $chamado); // A Lógica de Autorização está aqui!

        return view('chamados.edit', compact('chamado'));
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
        // Primeiramente, autoriza a atualização geral do chamado (proprietário ou técnico)
        $this->authorize('update', $chamado); // A Lógica de Autorização está aqui!

        // Regras de validação para todos os usuários
        $rules = [
            'titulo' => 'required|string|max:255',
            'descricao' => 'required|string',
            'prioridade' => 'required|in:baixa,media,alta',
            'status' => 'required|in:aberto,em andamento,resolvido,fechado',
        ];

        // Se o usuário NÃO for 'tecnica', ele não pode alterar prioridade nem status
        if (Auth::user()->role !== 'tecnica') { // **CORREÇÃO AQUI**
            // Se não é técnico, o status e a prioridade DEVEM ser os valores atuais do chamado
            $rules['prioridade'] = [
                'required',
                // Aceita apenas o valor atual do chamado para não técnicos
                Rule::in([$chamado->prioridade]),
            ];
            $rules['status'] = [
                'required',
                // Aceita apenas o valor atual do chamado para não técnicos
                Rule::in([$chamado->status]),
            ];
        }

        $validated = $request->validate($rules);

        // Se o usuário é "tecnica", ele pode atualizar todos os campos validados.
        // Se não é, o middleware de validação já garantiu que prioridade/status
        // só possam ser o valor atual do chamado, então podemos atualizar tudo.
        $chamado->update($validated);


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
        // Usa a policy 'delete'. Se o usuário não puder excluir, ele lança um 403.
        $this->authorize('delete', $chamado); // A Lógica de Autorização está aqui!

        $chamado->delete();

        return redirect()->route('chamados.index')->with('success', 'Chamado excluído com sucesso!');
    }
}