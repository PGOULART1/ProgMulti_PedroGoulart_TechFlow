<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editar Perfil - TechFlow</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 dark:bg-gray-900 flex items-center justify-center h-screen transition-colors duration-300">
    <div class="bg-white dark:bg-gray-800 p-8 rounded shadow-md w-96">
        <h2 class="text-2xl font-semibold mb-6 text-center text-gray-800 dark:text-white">Editar Perfil</h2>

        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                <p class="font-bold">Sucesso!</p>
                <p>{{ session('success') }}</p>
            </div>
        @endif

<div>
    <h2>Atualizar Perfil</h2>
    <form method="POST" action="{{ route('profile.update') }}">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="name" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Nome</label>
            <input id="name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-200 leading-tight focus:outline-none focus:shadow-outline dark:bg-gray-700 dark:border-gray-600" type="text" name="name" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
            @error('name')
                <p class="text-red-500 text-xs italic mt-2 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="email" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Email</label>
            <input id="email" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-200 leading-tight focus:outline-none focus:shadow-outline dark:bg-gray-700 dark:border-gray-600" type="email" name="email" value="{{ old('email', $user->email) }}" required autocomplete="email">
            @error('email')
                <p class="text-red-500 text-xs italic mt-2 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="password" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Nova Senha (Opcional)</label>
            <input id="password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-200 leading-tight focus:outline-none focus:shadow-outline dark:bg-gray-700 dark:border-gray-600" type="password" name="password" autocomplete="new-password">
            @error('password')
                <p class="text-red-500 text-xs italic mt-2 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="password_confirmation" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Confirmar Nova Senha</label>
            <input id="password_confirmation" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-200 leading-tight focus:outline-none focus:shadow-outline dark:bg-gray-700 dark:border-gray-600" type="password" name="password_confirmation" autocomplete="new-password">
        </div>

        <div class="flex items-center justify-end">
            <a href="{{ url()->previous() }}" class="bg-gray-300 hover:bg-gray-400 dark:bg-gray-600 dark:hover:bg-gray-500 text-gray-700 dark:text-gray-300 font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline mr-2">
                Voltar
            </a>
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 dark:bg-blue-600 dark:hover:bg-blue-500 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Atualizar
            </button>
        </div>

    </form>

    <hr class="my-8 border-t border-gray-300 dark:border-gray-700">

    <div>
        <h2>Deletar Conta</h2>
        <form action="{{ route('profile.destroy') }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir sua conta?');">
            @csrf
            @method('DELETE')

            <div class="mb-4">
                <label for="password" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Senha Atual</label>
                <input type="password" name="password" id="password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-200 leading-tight focus:outline-none focus:shadow-outline dark:bg-gray-700 dark:border-gray-600" required>
                @error('password', 'userDeletion')
                    <span class="text-red-500 text-xs italic mt-2 dark:text-red-400">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex items-center justify-end">
                
                <button type="submit" class="bg-red-500 hover:bg-red-700 dark:bg-red-600 dark:hover:bg-red-500 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Deletar Conta
                </button>
            </div>
        </form>
    </div>
</div>

        