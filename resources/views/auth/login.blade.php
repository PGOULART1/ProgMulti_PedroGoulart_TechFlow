{{-- blade-formatter-disable --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'TechFlow') }} - Login</title>
    
    <!-- Scripts Vite para CSS e JS compilados (inclui Tailwind CSS) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Google Fonts - Inter para um visual moderno e consistente -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Script para garantir o modo escuro padrão e persistir a preferência -->
    <script>
        // Esta lógica deve idealmente estar no seu app.blade.php principal
        // Mas está aqui para garantir que esta página específica inicie em dark mode.
        // Se o seu app.blade.php já configura o modo escuro padrão no <html>, este script pode ser mais simples ou removido.
        if (localStorage.getItem('darkMode') === 'disabled') {
            document.documentElement.classList.remove('dark');
        } else {
            document.documentElement.classList.add('dark');
            localStorage.setItem('darkMode', 'enabled'); // Garante que esteja sempre como 'enabled'
        }

        // Opcional: Escuta por mudanças no tema do sistema
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

<body class="font-inter bg-gray-100 dark:bg-gray-900 text-gray-700 dark:text-gray-300 flex items-center justify-center min-h-screen transition-colors duration-300 p-4">
    <div class="bg-white dark:bg-gray-800 p-8 md:p-10 rounded-xl shadow-2xl w-full max-w-md text-center transition-all duration-300">
        <!-- Logo - Usando a função asset() do Laravel para o logo da TechFlow -->
        <a href="{{ url('/') }}" class="block mb-6">
            <img src="{{ asset('img/techflowads_logo.jpg') }}" alt="TechFlow Logo" class="mx-auto h-20 sm:h-24 w-auto rounded-lg shadow-md" onerror="this.onerror=null;this.src='https://placehold.co/200x80/6366F1/FFFFFF?text=TechFlow+Logo';">
        </a>

        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Bem-vindo(a) de volta!</h1>
        <p class="text-gray-600 dark:text-gray-400 mb-8">Seu sistema de chamados completo.</p>

        <!-- Login Form - Usando rotas e proteção CSRF do Laravel -->
        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf

            <!-- Campo Email -->
            <div>
                <label for="email" class="sr-only">Email</label>
                <input type="email" id="email" name="email" placeholder="Seu email" required autofocus autocomplete="username" value="{{ old('email') }}"
                       class="w-full px-5 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 transition-colors duration-200"
                       aria-label="Email Address">
                @error('email')
                    <p class="text-red-500 text-xs italic mt-2 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Campo Senha -->
            <div>
                <label for="password" class="sr-only">Senha</label>
                <input type="password" id="password" name="password" placeholder="Sua senha" required autocomplete="current-password"
                       class="w-full px-5 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 transition-colors duration-200"
                       aria-label="Password">
                @error('password')
                    <p class="text-red-500 text-xs italic mt-2 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Opção "Lembrar-me" (opcional, adicionei para uma experiência completa de login) -->
            <div class="flex items-center justify-between">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-blue-600 shadow-sm focus:ring-blue-500" name="remember">
                    <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Lembrar-me') }}</span>
                </label>
                
                <!-- Link "Esqueceu a senha?" -->
                @if (Route::has('password.request'))
                    <a class="text-sm text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 transition-colors duration-200" href="{{ route('password.request') }}">
                        {{ __('Esqueceu sua senha?') }}
                    </a>
                @endif
            </div>

            <!-- Botão de Login -->
            <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-5 rounded-lg shadow-md hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition-all duration-200 transform hover:scale-105">
                Entrar
            </button>
        </form>

        <!-- Link para Registro -->
        <p class="mt-8 text-gray-600 dark:text-gray-400">
            Não tem uma conta?
            <a href="{{ route('register') }}" class="text-green-600 hover:text-green-800 dark:text-green-400 dark:hover:text-green-300 font-medium transition-colors duration-200">Registre-se</a>
        </p>
    </div>

    <!-- O botão de dark mode foi removido, pois o modo escuro será o padrão global
         e gerenciado pelo app.blade.php. -->
</body>
</html>
{{-- blade-formatter-enable --}}
