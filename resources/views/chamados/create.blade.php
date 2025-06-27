{{-- blade-formatter-disable --}}
<!-- 
    Este arquivo deve ser salvo como um arquivo Blade (.blade.php), por exemplo: 
    resources/views/chamados/create.blade.php
-->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Criar Novo Chamado') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto bg-white dark:bg-gray-800 overflow-hidden shadow-2xl sm:rounded-xl p-8 transition-colors duration-300">
            <!-- Título do Formulário -->
            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 text-center">Abrir Novo Chamado</h3>
            <p class="text-gray-600 dark:text-gray-400 mb-8 text-center">Descreva seu problema para que possamos ajudar.</p>

            <form method="POST" action="{{ route('chamados.store') }}" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <!-- Campo Título -->
                <div>
                    <label for="titulo" class="block text-gray-700 dark:text-gray-300 text-sm font-medium mb-2">Título do Chamado</label>
                    <input type="text" name="titulo" id="titulo" value="{{ old('titulo') }}" required autofocus
                           class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 transition-colors duration-200"
                           placeholder="Ex: Problema com o sistema de login">
                    @error('titulo')
                    <p class="text-red-500 text-xs italic mt-2 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Campo Descrição -->
                <div>
                    <label for="descricao" class="block text-gray-700 dark:text-gray-300 text-sm font-medium mb-2">Descrição Detalhada</label>
                    <textarea name="descricao" id="descricao" rows="6" required
                              class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 transition-colors duration-200"
                              placeholder="Forneça o máximo de detalhes possível sobre o problema ou solicitação.">{{ old('descricao') }}</textarea>
                    @error('descricao')
                    <p class="text-red-500 text-xs italic mt-2 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Campo Prioridade -->
                <div>
                    <label for="prioridade" class="block text-gray-700 dark:text-gray-300 text-sm font-medium mb-2">Prioridade</label>
                    <select name="prioridade" id="prioridade" required
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white transition-colors duration-200">
                        <option value="baixa" {{ old('prioridade') == 'baixa' ? 'selected' : '' }}>Baixa</option>
                        <option value="media" {{ old('prioridade') == 'media' ? 'selected' : '' }}>Média</option>
                        <option value="alta" {{ old('prioridade') == 'alta' ? 'selected' : '' }}>Alta</option>
                        <option value="urgente" {{ old('prioridade') == 'urgente' ? 'selected' : '' }}>Urgente</option>
                    </select>
                    @error('prioridade')
                    <p class="text-red-500 text-xs italic mt-2 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Equipe -->
                    <div class="mb-4">
                        <label for="equipe_id"
                            class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Equipe
                            Responsável</label>
                        <select name="equipe_id" id="equipe_id"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-200 leading-tight focus:outline-none focus:shadow-outline dark:bg-gray-700 dark:border-gray-600">
                            <option value="">Selecione uma equipe</option>
                            @foreach ($equipes as $equipe)
                            <option value="{{ $equipe->id }}" {{ old('equipe_id') == $equipe->id ? 'selected' : '' }}>
                                {{ $equipe->nome }}
                            </option>
                            @endforeach
                        </select>
                        @error('equipe_id')
                        <p class="text-red-500 text-xs italic mt-2 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                <!-- Campo Anexar Arquivos -->
                <div>
                    <label for="arquivos" class="block text-gray-700 dark:text-gray-300 text-sm font-medium mb-2">Anexar Arquivos (Opcional)</label>
                    <input type="file" name="arquivos[]" id="arquivos" multiple
                           class="block w-full text-sm text-gray-700 dark:text-gray-300 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-600 file:text-white hover:file:bg-blue-700 transition-colors duration-200 cursor-pointer" />
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Formatos permitidos: imagens, PDFs. Máximo de 5MB por arquivo.</p>
                    @error('arquivos')
                    <p class="text-red-500 text-xs italic mt-2 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Botões de Ação -->
                <div class="flex items-center justify-end space-x-4 pt-4">
                    <a href="{{ route('dashboard') }}"
                       class="inline-flex items-center px-6 py-3 border border-transparent text-sm font-medium rounded-lg shadow-sm text-gray-700 dark:text-gray-300 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200 transform hover:scale-105">
                        <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z"></path></svg>
                        Voltar
                    </a>

                    <button type="submit"
                            class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-lg shadow-lg text-white bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-200 transform hover:scale-105">
                        <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Criar Chamado
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
{{-- blade-formatter-enable --}}
