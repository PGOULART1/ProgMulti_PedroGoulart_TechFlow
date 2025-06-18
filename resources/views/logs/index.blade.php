<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Histórico de Ações') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    @if ($logs->isEmpty())
                        <p class="text-center text-gray-500 dark:text-gray-400">Nenhum registro encontrado.</p>
                    @else
                        <table class="min-w-full table-auto border-collapse border border-gray-300 dark:border-gray-700">
                            <thead>
                                <tr class="bg-gray-100 dark:bg-gray-700">
                                    <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-left text-sm font-semibold">Usuário</th>
                                    <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-left text-sm font-semibold">Ação</th>
                                    <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-left text-sm font-semibold">Detalhes</th>
                                    <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-left text-sm font-semibold">Data</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($logs as $log)
                                    <tr class="{{ $loop->even ? 'bg-white dark:bg-gray-800' : 'bg-gray-50 dark:bg-gray-900' }}">
                                        <td class="border border-gray-300 dark:border-gray-700 px-4 py-2 text-sm">
                                            {{ $log->user->name ?? 'Usuário Excluído' }}
                                        </td>
                                        <td class="border border-gray-300 dark:border-gray-700 px-4 py-2 text-sm">
                                            {{ $log->acao }}
                                        </td>
                                        <td class="border border-gray-300 dark:border-gray-700 px-4 py-2 text-sm">
                                            {{ $log->detalhes }}
                                        </td>
                                        <td class="border border-gray-300 dark:border-gray-700 px-4 py-2 text-sm">
                                            {{ $log->created_at->format('d/m/Y H:i') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="mt-4">
                            {{ $logs->links() }}
                        </div>
                    @endif

                    <div class="mt-6">
                        <a href="{{ route('dashboard') }}" class="inline-block bg-gray-300 hover:bg-gray-400 dark:bg-gray-600 dark:hover:bg-gray-500 text-gray-700 dark:text-gray-300 font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Voltar ao Dashboard
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
