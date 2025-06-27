<x-app-layout>
    <!-- Slot para o cabeçalho da página, exibido pelo layout principal -->
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Pagina Inicial') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg transition-colors duration-300">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <!-- Saudação personalizada ao usuário logado -->
                    <h1 class="text-3xl font-bold mb-2">Olá, {{ Auth::user()->name }}!</h1>
                    <p class="mt-2 text-lg text-gray-600 dark:text-gray-400">Bem-vindo(a) ao painel de controle TechFlow.</p>

                    <!-- Seção de Ações Rápidas (Botões) -->
                    <div class="mt-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <!-- Botão para Criar Novo Chamado -->
                        <a href="{{ route('chamados.create') }}" 
                           class="flex items-center justify-center bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-bold py-4 px-6 rounded-lg shadow-lg hover:shadow-xl transition-all duration-200 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Criar Novo Chamado
                        </a>
                        <!-- Botão para Ver Meus Chamados -->
                        <a href="{{ route('chamados.index') }}" 
                           class="flex items-center justify-center bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-bold py-4 px-6 rounded-lg shadow-lg hover:shadow-xl transition-all duration-200 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                            Ver Meus Chamados
                        </a>
                        <!-- Botão para Ver Chamados Concluídos (NOVO) -->
                        <a href="{{ route('chamados.concluidos') }}" 
                           class="flex items-center justify-center bg-gradient-to-r from-teal-500 to-teal-600 hover:from-teal-600 hover:to-teal-700 text-white font-bold py-4 px-6 rounded-lg shadow-lg hover:shadow-xl transition-all duration-200 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806L12 2.928l2.219.963a3.42 3.42 0 001.946.806 3.42 3.42 0 013.139 3.139 3.42 3.42 0 00.806 1.946l.963 2.219.963-2.219a3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.139-3.139 3.42 3.42 0 001.946-.806L21 2.928l-.963-2.219zM12 15h.01M12 19h.01"></path></svg>
                            Ver Chamados Concluídos
                        </a>
                        <!-- Botão para Editar Perfil -->
                        <a href="{{ route('profile.edit') }}" 
                           class="flex items-center justify-center bg-gradient-to-r from-gray-500 to-gray-600 hover:from-gray-600 hover:to-gray-700 text-white font-bold py-4 px-6 rounded-lg shadow-lg hover:shadow-xl transition-all duration-200 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 112 2h2a2 2 0 11-2 2v1"></path></svg>
                            Editar Perfil
                        </a>

                        <!-- Botões Exclusivos para Usuários com Role 'tecnica' -->
                        @if(Auth::user()->role === 'tecnica')
                            <!-- Botão para Criar Nova Equipe -->
                            <a href="{{ route('equipes.create') }}" 
                               class="flex items-center justify-center bg-gradient-to-r from-purple-500 to-purple-600 hover:from-purple-600 hover:to-purple-700 text-white font-bold py-4 px-6 rounded-lg shadow-lg hover:shadow-xl transition-all duration-200 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h2a2 2 0 002-2V7a2 2 0 00-2-2h-3V3H8v2H5a2 2 0 00-2 2v11a2 2 0 002 2h2m4-11V6a2 2 0 114 0v3m-4 0v3m-4-3v3m-4-3v3"></path></svg>
                                Criar Nova Equipe
                            </a>
                            <!-- Botão para Ver Equipes -->
                            <a href="{{ route('equipes.index') }}" 
                               class="flex items-center justify-center bg-gradient-to-r from-teal-500 to-teal-600 hover:from-teal-600 hover:to-teal-700 text-white font-bold py-4 px-6 rounded-lg shadow-lg hover:shadow-xl transition-all duration-200 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h2a2 2 0 002-2V7a2 2 0 00-2-2h-3V3H8v2H5a2 2 0 00-2 2v11a2 2 0 002 2h2m4-11V6a2 2 0 114 0v3m-4 0v3m-4-3v3m-4-3v3"></path></svg>
                                Ver Equipes
                            </a>
                            <!-- Botão para Ver Histórico de Ações -->
                            <a href="{{ route('logs.index') }}" 
                               class="flex items-center justify-center bg-gradient-to-r from-yellow-500 to-yellow-600 hover:from-yellow-600 hover:to-yellow-700 text-white font-bold py-4 px-6 rounded-lg shadow-lg hover:shadow-xl transition-all duration-200 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Ver Histórico de Ações
                            </a>
                        @endif
                    </div>

                    <!-- Seção de Widgets (Exemplo - pode ser expandida) -->
                    <div class="mt-12">
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Visão Geral</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <!-- Widget de Chamados Abertos -->
                            <div class="bg-blue-100 dark:bg-blue-900 p-6 rounded-lg shadow-md flex items-center justify-between transition-colors duration-300">
                                <div class="text-left">
                                    <p class="text-xl font-semibold text-blue-800 dark:text-blue-200">Chamados Abertos</p>
                                    <p class="text-4xl font-extrabold text-blue-900 dark:text-blue-100 mt-2">5</p>
                                </div>
                                <svg class="w-16 h-16 text-blue-500 dark:text-blue-400 opacity-20" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 001 1h14a1 1 0 001-1V4a1 1 0 00-1-1H3zm2 2h10v2H5V5zm0 4h10v2H5V9zm0 4h10v2H5v-2z" clip-rule="evenodd"></path></svg>
                            </div>

                            <!-- Widget de Chamados Concluídos -->
                            <div class="bg-green-100 dark:bg-green-900 p-6 rounded-lg shadow-md flex items-center justify-between transition-colors duration-300">
                                <div class="text-left">
                                    <p class="text-xl font-semibold text-green-800 dark:text-green-200">Chamados Concluídos</p>
                                    <p class="text-4xl font-extrabold text-green-900 dark:text-green-100 mt-2">25</p>
                                </div>
                                <svg class="w-16 h-16 text-green-500 dark:text-green-400 opacity-20" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                            </div>

                            <!-- Widget de Notificações Pendentes -->
                            <div class="bg-yellow-100 dark:bg-yellow-900 p-6 rounded-lg shadow-md flex items-center justify-between transition-colors duration-300">
                                <div class="text-left">
                                    <p class="text-xl font-semibold text-yellow-800 dark:text-yellow-200">Notificações</p>
                                    <p class="text-4xl font-extrabold text-yellow-900 dark:text-yellow-100 mt-2">3</p>
                                </div>
                                <svg class="w-16 h-16 text-yellow-500 dark:text-yellow-400 opacity-20" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"></path></svg>
                            </div>
                        </div>
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
            if (!localStorage.getItem('darkMode')) { // Only apply if user hasn't explicitly set a preference via an (now removed) toggle
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
