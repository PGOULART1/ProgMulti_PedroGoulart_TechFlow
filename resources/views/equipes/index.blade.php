<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Equipes') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-end mb-4">
                <a href="{{ route('equipes.create') }}" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">
                    Nova Equipe
                </a>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                @if (session('success'))
                    <div class="mb-4 text-green-600 dark:text-green-400 font-medium">
                        {{ session('success') }}
                    </div>
                @endif

                <table class="w-full table-auto text-left">
                    <thead>
                        <tr class="bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300">
                            <th class="px-4 py-2">ID</th>
                            <th class="px-4 py-2">Nome</th>
                            <th class="px-4 py-2">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($equipes as $equipe)
                            <tr class="border-b border-gray-300 dark:border-gray-700">
                                <td class="px-4 py-2">{{ $equipe->id }}</td>
                                <td class="px-4 py-2">{{ $equipe->nome }}</td>
                                <td class="px-4 py-2 flex gap-2">
                                    <a href="{{ route('equipes.show', $equipe) }}" class="text-blue-500 hover:underline">Ver</a>
                                    <a href="{{ route('equipes.edit', $equipe) }}" class="text-yellow-500 hover:underline">Editar</a>
                                    <form method="POST" action="{{ route('equipes.destroy', $equipe) }}" onsubmit="return confirm('Deseja excluir esta equipe?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:underline">Excluir</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-6">
                    {{ $equipes->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
