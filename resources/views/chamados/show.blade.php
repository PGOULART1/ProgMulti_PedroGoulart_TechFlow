<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detalhes do Chamado') }} #{{ $chamado->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-8 transition-colors duration-300">

                <h3 class="text-3xl font-bold text-gray-900 dark:text-white mb-6 text-center">
                    Detalhes do Chamado: <span class="text-blue-600 dark:text-blue-400">{{ $chamado->titulo }}</span>
                </h3>

                <!-- Detalhes do Chamado -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8 text-lg">
                    <div>
                        <p class="font-semibold text-gray-700 dark:text-gray-300">ID do Chamado:</p>
                        <p class="text-gray-900 dark:text-gray-100">{{ $chamado->id }}</p>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-700 dark:text-gray-300">Status:</p>
                        <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full capitalize
                            @if($chamado->status == 'aberto') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300
                            @elseif($chamado->status == 'em andamento') bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-300
                            @elseif($chamado->status == 'concluido') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300
                            @else bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-300 @endif">
                            {{ ucfirst($chamado->status ?? 'Não Definido') }}
                        </span>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-700 dark:text-gray-300">Prioridade:</p>
                        <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full capitalize
                            @if($chamado->prioridade == 'alta') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300
                            @elseif($chamado->prioridade == 'media') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300
                            @elseif($chamado->prioridade == 'urgente') bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-300
                            @else bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300 @endif">
                            {{ ucfirst($chamado->prioridade) }}
                        </span>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-700 dark:text-gray-300">Criado por:</p>
                        <p class="text-gray-900 dark:text-gray-100">{{ $chamado->user->name ?? 'Usuário Removido' }}</p>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-700 dark:text-gray-300">Equipe Responsável:</p>
                        <p class="text-gray-900 dark:text-gray-100">{{ $chamado->equipe->nome ?? 'Não Atribuída' }}</p>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-700 dark:text-gray-300">Data de Criação:</p>
                        <p class="text-gray-900 dark:text-gray-100">{{ $chamado->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>

                <div class="mb-8">
                    <p class="font-semibold text-gray-700 dark:text-gray-300 mb-2">Descrição:</p>
                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg shadow-inner text-gray-800 dark:text-gray-200 prose dark:prose-invert max-w-none">
                        {{ $chamado->descricao }}
                    </div>
                </div>

                <!-- Seção de Anexos (Com Miniaturas/Ícones) -->
                <div class="mb-8 pt-8 border-t border-gray-200 dark:border-gray-700">
                    <h4 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Anexos</h4>
                    @if($chamado->anexos->isEmpty())
                        <p class="text-gray-600 dark:text-gray-400">Nenhum anexo para este chamado.</p>
                    @else
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                            @foreach ($chamado->anexos as $anexo)
                                @php
                                    $fileUrl = Storage::url($anexo->caminho);
                                    // Determinar se é uma imagem com base na extensão ou tipo_mime (se disponível)
                                    $isImage = false;
                                    $extension = pathinfo($anexo->caminho, PATHINFO_EXTENSION);
                                    $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'];
                                    if (in_array(strtolower($extension), $imageExtensions)) {
                                        $isImage = true;
                                    } elseif (isset($anexo->tipo_mime) && str_starts_with($anexo->tipo_mime, 'image/')) {
                                        $isImage = true;
                                    }
                                @endphp
                                <a href="{{ $fileUrl }}" target="_blank"
                                   class="flex flex-col items-center justify-center p-3 border border-gray-200 dark:border-gray-700 rounded-lg shadow-sm bg-gray-50 dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors duration-200 text-center">
                                    @if($isImage)
                                        <img src="{{ $fileUrl }}" alt="{{ basename($anexo->nome_original) }}" class="w-20 h-20 object-cover rounded-md mb-2 shadow">
                                    @else
                                        {{-- Ícone para outros tipos de arquivo (ex: PDF, documento) --}}
                                        <svg class="w-12 h-12 mb-2 text-blue-500 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                    @endif
                                    <span class="text-sm font-medium text-gray-800 dark:text-gray-200 truncate w-full">{{ basename($anexo->arquivo) }}</span>
                                </a>
                            @endforeach
                        </div>
                    @endif
                    <!-- Formulário para Adicionar Mais Anexos (visível para técnicos ou criador do chamado) -->
                    @if(Auth::user()->role === 'tecnica' || Auth::id() === $chamado->user_id)
                        <div class="mt-4">
                            <form action="{{ route('chamados.anexos.store', $chamado) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                                @csrf
                                <label for="novo_anexo" class="block text-gray-700 dark:text-gray-300 text-sm font-medium mb-2">Adicionar Novo Anexo</label>
                                <input type="file" name="arquivo" id="novo_anexo" required
                                    class="block w-full text-sm text-gray-700 dark:text-gray-300 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-600 file:text-white hover:file:bg-blue-700 transition-colors duration-200 cursor-pointer" />
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Apenas um arquivo por vez. Máximo: 5MB.</p>
                                @error('arquivo')
                                    <p class="text-red-500 text-xs italic mt-2 dark:text-red-400">{{ $message }}</p>
                                @enderror
                                <div class="flex justify-end">
                                    <button type="submit"
                                            class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-lg shadow-lg text-white bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 transform hover:scale-105">
                                        <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                        Adicionar Anexo
                                    </button>
                                </div>
                            </form>
                        </div>
                    @endif
                </div>

                <!-- Seção de Mensagens (Histórico de Interações) -->
                <div class="mb-8 pt-8 border-t border-gray-200 dark:border-gray-700">
                    <h4 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Histórico de Interações</h4>
                    <div class="space-y-4">
                        @forelse ($chamado->mensagens as $mensagem)
                            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg shadow-sm">
                                <div class="flex items-center justify-between text-sm text-gray-600 dark:text-gray-400 mb-2">
                                    <span class="font-semibold">{{ $mensagem->user->name ?? 'Usuário Desconhecido' }}</span>
                                    <span>{{ $mensagem->created_at->format('d/m/Y H:i') }}</span>
                                </div>
                                <p class="text-gray-800 dark:text-gray-200">{{ $mensagem->mensagem }}</p>
                            </div>
                        @empty
                            <p class="text-gray-600 dark:text-gray-400">Nenhuma interação registrada ainda.</p>
                        @endforelse
                    </div>
                </div>

                <!-- Formulário para Adicionar Nova Mensagem (apenas para técnicos ou para o criador do chamado) -->
                @if(Auth::user()->role === 'tecnica' || Auth::id() === $chamado->user_id)
                    <div class="mt-8 pt-8 border-t border-gray-200 dark:border-gray-700">
                        <h4 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Adicionar Nova Interação</h4>
                        <form method="POST" action="{{ route('mensagens.store') }}" class="space-y-4">
                            @csrf
                            <input type="hidden" name="chamado_id" value="{{ $chamado->id }}">
                            <div>
                                <label for="mensagem" class="sr-only">Sua Mensagem</label>
                                <textarea name="mensagem" id="mensagem" rows="3" required
                                          class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 transition-colors duration-200"
                                          placeholder="Digite sua mensagem ou atualização aqui.">{{ old('mensagem') }}</textarea>
                                @error('mensagem')
                                <p class="text-red-500 text-xs italic mt-2 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="flex justify-end">
                                <button type="submit"
                                        class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-lg shadow-lg text-white bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 transform hover:scale-105">
                                    <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.11C6.23 15.414 4 13.715 4 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                                    Enviar Mensagem
                                </button>
                            </div>
                        </form>
                    </div>
                @endif

                <!-- Botões de Ação (Voltar e Fechar Chamado) -->
                <div class="mt-8 flex justify-between items-center pt-8 border-t border-gray-200 dark:border-gray-700">
                    <a href="{{ route('chamados.index') }}"
                       class="inline-flex items-center px-6 py-3 border border-transparent text-sm font-medium rounded-lg shadow-sm text-gray-700 dark:text-gray-300 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200 transform hover:scale-105">
                        <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z"></path></svg>
                        Voltar para Chamados
                    </a>

                    @if(Auth::user()->role === 'tecnica' && $chamado->status !== 'concluido')
                        <form method="POST" action="{{ route('chamados.close', $chamado) }}" onsubmit="return confirm('Tem certeza que deseja fechar este chamado? Esta ação é irreversível.');">
                            @csrf
                            @method('PUT')
                            <button type="submit"
                                    class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-lg shadow-lg text-white bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all duration-200 transform hover:scale-105">
                                <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Fechar Chamado
                            </button>
                        </form>
                    @endif
                </div>

            </div>
        </div>
    </div>

    <script>
        // Preview para arquivo anexo selecionado (imagem mostra miniatura)
        document.getElementById('arquivo').addEventListener('change', function(event) {
            const preview = document.getElementById('preview');
            preview.innerHTML = '';

            const file = event.target.files[0];
            if (!file) return;

            const imageTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/bmp', 'image/webp'];

            if (imageTypes.includes(file.type)) {
                const img = document.createElement('img');
                img.style.maxWidth = '80px';
                img.style.maxHeight = '80px';
                img.style.borderRadius = '4px';
                img.style.boxShadow = '0 0 5px rgba(0,0,0,0.2)';
                img.alt = "Pré-visualização do anexo";
                img.src = URL.createObjectURL(file);
                preview.appendChild(img);
            } else {
                const p = document.createElement('p');
                p.textContent = `Arquivo selecionado: ${file.name}`;
                preview.appendChild(p);
            }
        });
    </script>
</x-app-layout>
