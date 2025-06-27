<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechFlow - Login</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        // Configure Tailwind to enable dark mode based on the 'dark' class on the HTML element
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        inter: ['Inter', 'sans-serif'], // Define Inter font
                    },
                }
            }
        }
    </script>
    <!-- Google Fonts - Inter for a modern look -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>

<body class="font-inter bg-gray-100 dark:bg-gray-900 text-gray-700 dark:text-gray-300 flex items-center justify-center min-h-screen transition-colors duration-300 p-4">
    <div class="bg-white dark:bg-gray-800 p-8 md:p-10 rounded-xl shadow-2xl w-full max-w-md text-center transition-all duration-300">
        <!-- Logo -->
        <!-- Using a placeholder image since the original path is Laravel-specific -->
        <img src="img/techflowads_logo.jpg" alt="TechFlow Logo" class="mx-auto h-20 sm:h-24 w-auto mb-6 rounded-lg shadow-md">

        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Bem-vindo(a) de volta!</h1>
        <p class="text-gray-600 dark:text-gray-400 mb-8">Seu sistema de chamados completo.</p>

        <!-- Login Form -->
        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf
            <div>
                <label for="email" class="sr-only">Email</label>
                <input type="email" id="email" name="email" placeholder="Seu email" required
                       class="w-full px-5 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 transition-colors duration-200"
                       aria-label="Email Address">
            </div>
            <div>
                <label for="password" class="sr-only">Senha</label>
                <input type="password" id="password" name="password" placeholder="Sua senha" required
                       class="w-full px-5 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 transition-colors duration-200"
                       aria-label="Password">
            </div>

            <!-- Forgot Password Link -->
            <div class="text-right">
                <a href="#" class="text-sm text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 transition-colors duration-200">Esqueceu a senha?</a>
            </div>

            <!-- Login Button -->
            <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-5 rounded-lg shadow-md hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition-all duration-200 transform hover:scale-105">
                Entrar
            </button>
        </form>

        <!-- Register Link -->
        <p class="mt-8 text-gray-600 dark:text-gray-400">
            Não tem uma conta?
            <a href="{{ route('register') }}" class="text-green-600 hover:text-green-800 dark:text-green-400 dark:hover:text-green-300 font-medium transition-colors duration-200">Registre-se</a>
        </p>

        <!-- Dark Mode Toggle Button -->
        <button id="dark-mode-toggle"
                class="mt-8 p-3 rounded-full bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 focus:outline-none transition-all duration-300 shadow-lg">
            <!-- Sun Icon (Light Mode) -->
            <svg id="sun-icon" class="h-6 w-6 hidden dark:block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h1M3 12h1m15.325-3.325l-.707.707M5.372 18.06l-.707.707M18.06 5.372l-.707-.707M6.06 6.06l-.707-.707"/>
            </svg>
            <!-- Moon Icon (Dark Mode) -->
            <svg id="moon-icon" class="h-6 w-6 dark:hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
            </svg>
        </button>
    </div>

    <script>
        const darkModeToggle = document.getElementById('dark-mode-toggle');
        const htmlElement = document.documentElement; // Target the <html> element for Tailwind dark mode

        // Function to set the dark mode preference
        function setDarkMode(isDark) {
            if (isDark) {
                htmlElement.classList.add('dark');
                localStorage.setItem('darkMode', 'enabled');
            } else {
                htmlElement.classList.remove('dark');
                localStorage.setItem('darkMode', 'disabled');
            }
        }

        // Apply saved preference on page load
        if (localStorage.getItem('darkMode') === 'enabled' || (!('darkMode' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            setDarkMode(true);
        } else {
            setDarkMode(false); // Ensure light mode is set if no preference or explicitly disabled
        }

        // Toggle dark mode on button click
        darkModeToggle.addEventListener('click', () => {
            setDarkMode(!htmlElement.classList.contains('dark'));
        });

        // Optional: Listen for system theme changes
        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
            if (!('darkMode' in localStorage)) { // Only apply if user hasn't explicitly set a preference
                setDarkMode(e.matches);
            }
        });
    </script>
</body>
</html>
