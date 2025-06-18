<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">Atribuir Usuários à Equipe</h2>
    </x-slot>

    <div class="p-6">
        <form method="POST" action="{{ route('equipes.usuarios.update') }}">
            @csrf

            <div>
                <label for="equipe_id">Selecione a Equipe:</label>
                <select name="equipe_id" id="equipe_id" required class="block w-full">
                    @foreach($equipes as $equipe)
                        <option value="{{ $equipe->id }}">{{ $equipe->nome }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mt-4">
                <label>Selecione os Usuários:</label>
                @foreach($usuarios as $usuario)
                    <div>
                        <input type="checkbox" name="usuarios[]" value="{{ $usuario->id }}">
                        {{ $usuario->name }} ({{ $usuario->email }})
                    </div>
                @endforeach
            </div>

            <button type="submit" class="mt-4 bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Atribuir
            </button>
        </form>
    </div>
</x-app-layout>
