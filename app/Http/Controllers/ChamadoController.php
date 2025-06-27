<?php

namespace App\Http\Controllers;

use App\Models\Chamado;
use App\Models\Equipe;
use App\Models\Log;
use App\Models\Mensagem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\Anexo;
use Illuminate\Support\Facades\Storage;


class ChamadoController extends Controller
{
    use AuthorizesRequests;

    /**
     * Exibe a lista de chamados do usuário.
     */
    public function index(): View
    {
        $user = Auth::user();
        $query = Chamado::with('user', 'equipe');

        if ($user->role === 'tecnica') {
            // Técnicos veem chamados abertos ou em andamento
            $query->whereIn('status', ['aberto', 'em andamento']);
        } else {
            // Usuários comuns veem APENAS seus chamados abertos ou em andamento
            $query->where('user_id', $user->id)
                  ->whereIn('status', ['aberto', 'em andamento']);
        }

        $chamados = $query->latest()->paginate(10); // Ordena pelos mais recentes e pagina

        return view('chamados.index', compact('chamados'));
    }

    /**
     * Exibe o formulário para criar um novo chamado.
     */
    public function create(): View
    {
        $equipes = Equipe::all();
        return view('chamados.create', compact('equipes'));
    }

    /**
     * Salva um novo chamado no banco de dados.
     */
    public function store(Request $request): RedirectResponse
{ 
    $validated = $request->validate([
        'titulo' => 'required|string|max:255',
        'descricao' => 'required|string',
        'prioridade' => 'required|in:baixa,media,alta',
        'equipe_id' => 'nullable|exists:equipes,id',
        'arquivos.*' => 'nullable|file|max:5120', // até 5MB por arquivo
    ]);

    $chamado = Chamado::create([
        'user_id' => Auth::id(),
        'titulo' => $validated['titulo'],
        'descricao' => $validated['descricao'],
        'prioridade' => $validated['prioridade'],
        'equipe_id' => $validated['equipe_id'] ?? null,
        'status' => 'aberto',
    ]);

    // Verifica se há múltiplos arquivos enviados
    if ($request->hasFile('arquivos')) {
        foreach ($request->file('arquivos') as $arquivo) {
            // Salva o arquivo no disco 'public' dentro da pasta 'anexos'
            // NOTA: Se você usa 'chamados_anexos' em adicionarAnexo, seja consistente aqui.
            // Eu manteria 'anexos' se sua migration for genérica para anexos.
            $path = $arquivo->store('anexos', 'public'); 

            // === CORREÇÃO AQUI ===
            // Use as mesmas colunas da sua migration
            $chamado->anexos()->create([
                'nome_arquivo_hash' => basename($path), // Obtém apenas o nome do arquivo (ex: 'abcdef123.png')
                'nome_original' => $arquivo->getClientOriginalName(),
                'tipo_mime' => $arquivo->getMimeType(),
                'caminho' => $path, // O caminho completo no storage (ex: 'anexos/abcdef123.png')
                'tamanho' => $arquivo->getSize(),
            ]);
            // === FIM DA CORREÇÃO ===
        }
    }

    Log::create([
        'user_id' => auth()->id(),
        'acao' => 'Criou um chamado',
        'detalhes' => 'Título: ' . $chamado->titulo,
    ]);

    return redirect()->route('chamados.index')->with('success', 'Chamado criado com sucesso!');
}

    /**
     * Exibe os detalhes de um chamado específico.
     */
    public function show(Chamado $chamado): View
    {
        $this->authorize('view', $chamado);
        // carregar mensagens com usuário para evitar N+1
        $chamado->load(['mensagens.user', 'equipe', 'anexos', 'user']);
        return view('chamados.show', compact('chamado'));
    }

    /**
     * Exibe o formulário de edição de um chamado.
     */
    public function edit(Chamado $chamado): View
    {
        $this->authorize('update', $chamado);
        $equipes = Equipe::all();
        return view('chamados.edit', compact('chamado', 'equipes'));
    }

    /**
     * Atualiza um chamado existente.
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
            $rules['prioridade'] = ['required', Rule::in([$chamado->prioridade])];
            $rules['status'] = ['required', Rule::in([$chamado->status])];
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
     * Remove um chamado.
     */
    public function destroy(Chamado $chamado): RedirectResponse
    {
        $this->authorize('delete', $chamado);

        $titulo = $chamado->titulo;
        $chamado->delete();

        Log::create([
            'user_id' => auth()->id(),
            'acao' => 'Excluiu um chamado',
            'detalhes' => 'Título: ' . $titulo,
        ]);

        return redirect()->route('chamados.index')->with('success', 'Chamado excluído com sucesso!');
    }

    /**
     * Salva uma nova mensagem (comentário) no histórico do chamado.
     */
    public function storeMensagem(Request $request, Chamado $chamado): RedirectResponse
    {
        $this->authorize('view', $chamado);

        $validated = $request->validate([
            'mensagem' => 'required|string|max:1000',
        ]);

        $chamado->mensagens()->create([
            'user_id' => Auth::id(),
            'mensagem' => $validated['mensagem'],
        ]);

        Log::create([
            'user_id' => auth()->id(),
            'acao' => 'Adicionou uma mensagem ao chamado',
            'detalhes' => 'Chamado: ' . $chamado->titulo,
        ]);

        return redirect()->route('chamados.show', $chamado)->with('success', 'Mensagem enviada com sucesso!');
    }

    public function adicionarAnexo(Request $request, Chamado $chamado)
    {
        $request->validate([
            'anexo_arquivo' => 'required|file|max:20480', // 20MB max, ajuste conforme necessário
        ]);

        if ($request->hasFile('anexo_arquivo')) {
            $file = $request->file('anexo_arquivo');

            // Salva o arquivo no disco 'public' dentro da pasta 'chamados_anexos'
            // O caminho retornado será algo como 'chamados_anexos/nomehash.png'
            $path = $file->store('chamados_anexos', 'public');

            $anexo = new Anexo();
            $anexo->chamado_id = $chamado->id;
            $anexo->nome_arquivo_hash = basename($path); // Apenas o nome do arquivo com hash
            $anexo->nome_original = $file->getClientOriginalName();
            $anexo->tipo_mime = $file->getMimeType();
            $anexo->caminho = $path; // O caminho completo relativo ao storage/app/public/
            $anexo->tamanho = $file->getSize();
            $anexo->save();

            return redirect()->back()->with('success', 'Anexo adicionado com sucesso!');
        }

        return redirect()->back()->with('error', 'Nenhum arquivo enviado.');
    }

    public function close(Chamado $chamado)
    {
        // Somente técnicos podem fechar chamados
        if (Auth::user()->role !== 'tecnica') {
            return back()->with('error', 'Você não tem permissão para fechar chamados.');
        }

        // Não permitir fechar um chamado já concluído
        if ($chamado->status === 'concluido') {
            return back()->with('info', 'Este chamado já está concluído.');
        }

        $chamado->status = 'concluido';
        $chamado->save();

        // Opcional: Adicionar uma mensagem ao histórico do chamado indicando que foi fechado
        Mensagem::create([
            'chamado_id' => $chamado->id,
            'user_id' => Auth::id(),
            'mensagem' => 'Chamado marcado como "Concluído" por ' . Auth::user()->name . '.',
        ]);

        return redirect()->route('chamados.index')->with('success', 'Chamado fechado com sucesso!');
    }

    /**
     * Exibe uma lista de chamados concluídos.
     *
     * @return \Illuminate\View\View
     */
    public function concluidos()
    {
        $user = Auth::user();
        $query = Chamado::with('user', 'equipe');

        if ($user->role === 'tecnica') {
            // Técnicos veem TODOS os chamados concluídos
            $query->where('status', 'concluido');
        } else {
            // Usuários comuns veem APENAS seus chamados concluídos
            $query->where('user_id', $user->id)
                  ->where('status', 'concluido');
        }

        $chamados = $query->latest()->paginate(10);

        return view('chamados.concluidos_index', compact('chamados'));
    }
}