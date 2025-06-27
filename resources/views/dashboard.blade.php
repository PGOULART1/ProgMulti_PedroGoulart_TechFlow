<x-app-layout>
    <!-- Slot para o cabeçalho da página, exibido pelo layout principal -->
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Pagina Inicial') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div
                class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg transition-colors duration-300">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <!-- Saudação personalizada ao usuário logado -->
                    <h1 class="text-3xl font-bold mb-2">Olá, {{ Auth::user()->name }}!</h1>
                    <p class="mt-2 text-lg text-gray-600 dark:text-gray-400">Bem-vindo(a) ao painel de controle
                        TechFlow.</p>

                    <!-- Seção de Ações Rápidas (Botões) -->
                    <div class="mt-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <!-- Botão para Criar Novo Chamado -->
                        <a href="{{ route('chamados.create') }}"
                            class="flex items-center justify-center bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-bold py-4 px-6 rounded-lg shadow-lg hover:shadow-xl transition-all duration-200 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Criar Novo Chamado
                        </a>
                        <!-- Botão para Ver Meus Chamados -->
                        <a href="{{ route('chamados.index') }}"
                            class="flex items-center justify-center bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-bold py-4 px-6 rounded-lg shadow-lg hover:shadow-xl transition-all duration-200 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                                </path>
                            </svg>
                            Ver Meus Chamados
                        </a>
                        <!-- Botão para Ver Chamados Concluídos (NOVO) -->
                        <a href="{{ route('chamados.concluidos') }}"
                            class="flex items-center justify-center bg-gradient-to-r from-teal-500 to-teal-600 hover:from-teal-600 hover:to-teal-700 text-white font-bold py-4 px-6 rounded-lg shadow-lg hover:shadow-xl transition-all duration-200 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806L12 2.928l2.219.963a3.42 3.42 0 001.946.806 3.42 3.42 0 013.139 3.139 3.42 3.42 0 00.806 1.946l.963 2.219.963-2.219a3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.139-3.139 3.42 3.42 0 001.946-.806L21 2.928l-.963-2.219zM12 15h.01M12 19h.01">
                                </path>
                            </svg>
                            Ver Chamados Concluídos
                        </a>
                        <!-- Botão para Editar Perfil -->
                        <a href="{{ route('profile.edit') }}"
                            class="flex items-center justify-center bg-gradient-to-r from-gray-500 to-gray-600 hover:from-gray-600 hover:to-gray-700 text-white font-bold py-4 px-6 rounded-lg shadow-lg hover:shadow-xl transition-all duration-200 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 112 2h2a2 2 0 11-2 2v1">
                                </path>
                            </svg>
                            Editar Perfil
                        </a>

                        <!-- Botões Exclusivos para Usuários com Role 'tecnica' -->
                        @if(Auth::user()->role === 'tecnica')
                        <!-- Botão para Criar Nova Equipe -->
                        <a href="{{ route('equipes.create') }}"
                            class="flex items-center justify-center bg-gradient-to-r from-purple-500 to-purple-600 hover:from-purple-600 hover:to-purple-700 text-white font-bold py-4 px-6 rounded-lg shadow-lg hover:shadow-xl transition-all duration-200 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h2a2 2 0 002-2V7a2 2 0 00-2-2h-3V3H8v2H5a2 2 0 00-2 2v11a2 2 0 002 2h2m4-11V6a2 2 0 114 0v3m-4 0v3m-4-3v3m-4-3v3">
                                </path>
                            </svg>
                            Criar Nova Equipe
                        </a>
                        <!-- Botão para Ver Equipes -->
                        <a href="{{ route('equipes.index') }}"
                            class="flex items-center justify-center bg-gradient-to-r from-teal-500 to-teal-600 hover:from-teal-600 hover:to-teal-700 text-white font-bold py-4 px-6 rounded-lg shadow-lg hover:shadow-xl transition-all duration-200 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h2a2 2 0 002-2V7a2 2 0 00-2-2h-3V3H8v2H5a2 2 0 00-2 2v11a2 2 0 002 2h2m4-11V6a2 2 0 114 0v3m-4 0v3m-4-3v3m-4-3v3">
                                </path>
                            </svg>
                            Ver Equipes
                        </a>
                        <!-- Botão para Ver Histórico de Ações -->
                        <a href="{{ route('logs.index') }}"
                            class="flex items-center justify-center bg-gradient-to-r from-yellow-500 to-yellow-600 hover:from-yellow-600 hover:to-yellow-700 text-white font-bold py-4 px-6 rounded-lg shadow-lg hover:shadow-xl transition-all duration-200 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Ver Histórico de Ações
                        </a>
                        @endif
                    </div>

                    <!-- Seção de Widgets -->
                     {{-- Seção de Visão Geral (SOMENTE PARA USUÁRIOS TÉCNICOS) --}}
                    @if(Auth::check() && Auth::user()->role === 'tecnica')
                        <div class="py-12">
                            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                                    <div class="p-6 text-gray-900 dark:text-gray-100"></div>
                                        <p class="mb-6 text-md text-gray-600 dark:text-gray-300">Aqui você encontra um resumo rápido do que está
                                            acontecendo.</p>

                                        <h3
                                            class="text-2xl font-bold mb-6 text-gray-800 dark:text-gray-100 border-b pb-3 border-gray-200 dark:border-gray-700">
                                            Visão Geral</h3>

                                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                            {{-- Ajustado para 2 colunas em MD e 3 em LG para melhor responsividade --}}

                                            <div class="bg-gradient-to-br from-blue-500 to-blue-700 p-6 rounded-xl shadow-lg text-white flex flex-col justify-between
                                    transform hover:scale-105 transition-all duration-300 ease-in-out cursor-pointer
                                    hover:shadow-2xl hover:brightness-110">
                                                <div class="flex items-center justify-between mb-4">
                                                    <h4 class="text-xl font-semibold opacity-90">Chamados Abertos</h4>
                                                    <svg class="h-10 w-10 text-blue-100 opacity-75" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                                                        </path>
                                                    </svg>
                                                </div>
                                                <p class="text-5xl font-extrabold">{{ $chamadosAbertos }}</p>
                                                <a href="{{ route('chamados.index', ['status' => 'aberto']) }}"
                                                    class="mt-4 text-right text-blue-100 opacity-80 hover:underline text-sm">Ver
                                                    todos &rarr;</a>
                                            </div>

                                            <div class="bg-gradient-to-br from-green-500 to-green-700 p-6 rounded-xl shadow-lg text-white flex flex-col justify-between
                                    transform hover:scale-105 transition-all duration-300 ease-in-out cursor-pointer
                                    hover:shadow-2xl hover:brightness-110">
                                                <div class="flex items-center justify-between mb-4">
                                                    <h4 class="text-xl font-semibold opacity-90">Chamados Concluídos
                                                    </h4>
                                                    <svg class="h-10 w-10 text-green-100 opacity-75" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                </div>
                                                <p class="text-5xl font-extrabold">{{ $chamadosConcluidos }}</p>
                                                <a href="{{ route('chamados.concluidos') }}"
                                                    class="mt-4 text-right text-green-100 opacity-80 hover:underline text-sm">Ver
                                                    todos &rarr;</a>
                                            </div>

                                            <div class="bg-gradient-to-br from-purple-500 to-purple-700 p-6 rounded-xl shadow-lg text-white flex flex-col justify-between
                                    transform hover:scale-105 transition-all duration-300 ease-in-out cursor-pointer
                                    hover:shadow-2xl hover:brightness-110">
                                                <div class="flex items-center justify-between mb-4">
                                                    <h4 class="text-xl font-semibold opacity-90">Total de Logs</h4>
                                                    <svg class="h-10 w-10 text-purple-100 opacity-75" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                                                        </path>
                                                    </svg>
                                                </div>
                                                <p class="text-5xl font-extrabold">{{ $totalLogs }}</p>
                                                <a href="{{ route('logs.index') }}"
                                                    class="mt-4 text-right text-purple-100 opacity-80 hover:underline text-sm">Ver
                                                    todos &rarr;</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif {{-- Fim da verificação para usuário 'tecnica' --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    const htmlElement = document.documentElement; // Target the <html> element for Tailwind dark mode

    // Define dark mode as default
    htmlElement.classList.add('dark');
    localStorage.setItem('darkMode', 'enabled');

    // Optional: Listen for system theme changes (still useful if user wants to override later)
    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
        // If the system theme changes, apply it. If dark mode is already set by default, this won't change anything unless the user manually clears localStorage.
        if (!localStorage.getItem(
                'darkMode'
                )) { // Only apply if user hasn't explicitly set a preference via an (now removed) toggle
            if (e.matches) {
                htmlElement.classList.add('dark');
            } else {
                htmlElement.classList.remove('dark');
            }
        }
    });
    </script>
</x-app-layout>
{{-- blade-formatter-enable --}}