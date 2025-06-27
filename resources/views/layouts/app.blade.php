{{-- blade-formatter-disable --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Título da Página - Usará o APP_NAME do seu .env (ex: TechFlow) -->
        <title>{{ config('app.name', 'TechFlow') }}</title>

        
        <!-- Se o seu arquivo for .ico, use: -->
         <link rel="icon" href="{{ asset('img/favicons/techflowads_logo.ico') }}" type="image/x-icon"> 
         <link rel="shortcut icon" href="{{ asset('img/favicons/techflowads_logo.ico') }}" type="image/x-icon">

        <!-- Fonts - Inter para um visual moderno e consistente -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

        <!-- Scripts Vite para CSS e JS compilados (inclui Tailwind CSS) -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Script para garantir o modo escuro padrão e persistir a preferência -->
        <script>
            // Aplica a classe 'dark' à <html> se a preferência não estiver explicitamente 'disabled'
            // O 'localStorage.setItem' garante que a preferência seja mantida para futuras visitas
            if (localStorage.getItem('darkMode') === 'disabled') {
                document.documentElement.classList.remove('dark');
            } else {
                document.documentElement.classList.add('dark');
                localStorage.setItem('darkMode', 'enabled'); 
            }

            // Opcional: Escuta por mudanças no tema do sistema, caso o usuário limpe o localStorage
            window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
                if (!localStorage.getItem('darkMode')) {
                    if (e.matches) {
                        document.documentElement.classList.add('dark');
                    } else {
                        document.documentElement.classList.remove('dark');
                    }
                }
            });
        </script>
    </head>
    <!-- Aplica a fonte Inter e as cores de fundo para o body -->
    <body class="font-inter antialiased bg-gray-100 dark:bg-gray-900 transition-colors duration-300">
        <div class="min-h-screen">
            <!-- Inclui a navegação principal (logo, links de menu, dropdown do usuário) -->
            @include('layouts.navigation')

            <!-- Page Heading (cabeçalho da página, injetado via $header slot) -->
            @isset($header)
                <header class="bg-white dark:bg-gray-800 shadow transition-colors duration-300">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content (conteúdo principal da página, injetado via $slot) -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
{{-- blade-formatter-enable --}}
