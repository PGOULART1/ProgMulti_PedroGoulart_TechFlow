<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ Auth::user()->role === 'tecnica' ? __('Chamados Abertos/Em Andamento') : __('Meus Chamados Ativos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg transition-colors duration-300">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-2xl font-bold">
                            @if(Auth::user()->role === 'tecnica')
                                Chamados Ativos
                            @else
                                Meus Chamados Ativos
                            @endif
                        </h3>
                        <a href="{{ route('chamados.create') }}"
                           class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition-all duration-200 transform hover:scale-105">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            {{ __('Abrir Novo Chamado') }}
                        </a>
                    </div>

                    @if ($chamados->isEmpty())
                        <p class="p-4 text-gray-700 dark:text-gray-300">{{ __('Nenhum chamado ativo encontrado.') }}</p>
                    @else
                        <div class="overflow-x-auto rounded-lg shadow-md">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-100 dark:bg-gray-700">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            {{ __('ID') }}
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            {{ __('Título') }}
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            {{ __('Prioridade') }}
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            {{ __('Status') }}
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            {{ __('Equipe') }}
                                        </th>
                                        @if(Auth::user()->role === 'tecnica')
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                {{ __('Criado Por') }}
                                            </th>
                                        @endif
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            {{ __('Criado Em') }}
                                        </th>
                                        <th scope="col" class="relative px-6 py-3">
                                            <span class="sr-only">{{ __('Ações') }}</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach ($chamados as $chamado)
                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                                    {{ $chamado->id }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="text-sm text-gray-900 dark:text-gray-100 truncate max-w-xs">
                                                    {{ $chamado->titulo }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                    @if($chamado->prioridade == 'alta') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300
                                                    @elseif($chamado->prioridade == 'media') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300
                                                    @elseif($chamado->prioridade == 'urgente') bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-300
                                                    @else bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300 @endif">
                                                    {{ ucfirst($chamado->prioridade) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                    @if($chamado->status == 'aberto') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300
                                                    @elseif($chamado->status == 'em andamento') bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-300
                                                    @elseif($chamado->status == 'concluido') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300
                                                    @else bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-300 @endif">
                                                    {{ ucfirst($chamado->status ?? 'Não Definido') }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                                {{ $chamado->equipe->nome ?? '—' }}
                                            </td>
                                            @if(Auth::user()->role === 'tecnica')
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                                    {{ $chamado->user->name ?? 'Usuário Removido' }}
                                                </td>
                                            @endif
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                                {{ $chamado->created_at->format('d/m/Y H:i') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <a href="{{ route('chamados.show', $chamado) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-600 mr-4 transition-colors duration-200">{{ __('Abrir Chat') }}</a>
                                                <a href="{{ route('chamados.edit', $chamado) }}" class="text-yellow-600 hover:text-yellow-900 dark:text-yellow-400 dark:hover:text-yellow-600 mr-4 transition-colors duration-200">{{ __('Editar') }}</a>
                                                <form action="{{ route('chamados.destroy', $chamado) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-600 transition-colors duration-200" onclick="return confirm('Tem certeza que deseja excluir este chamado?')">{{ __('Excluir') }}</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4">
                            {{ $chamados->links() }}
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>