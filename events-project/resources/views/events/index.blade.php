<x-app-layout><x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">{{ __('Meus Eventos') }}</h2> <a href="{{ route('events.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:bg-gray-200 dark:text-gray-800 dark:hover:bg-white dark:focus:bg-white dark:active:bg-gray-300 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                {{ __('Criar Novo Evento') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <!-- 👇 BLOCO DE SUCESSO ADICIONADO 👇 -->
                    <!-- Isso vai mostrar a mensagem 'Evento criado com sucesso!' -->
                    @if (session('success'))
                    <div class="mb-4 p-4 bg-green-100 dark:bg-green-900 border border-green-200 dark:border-green-700 text-green-700 dark:text-green-100 rounded-lg">
                        {{ session('success') }}
                    </div>
                    @endif

                    <!-- Tabela de Eventos -->
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Título
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Data do Evento
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Taxa (R$)
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Ações
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">

                            @forelse ($events as $event)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900 dark:text-gray-100">{{ $event->title }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900 dark:text-gray-100">{{ \Carbon\Carbon::parse($event->event_date)->format('d/m/Y H:i') }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900 dark:text-gray-100">{{ number_format($event->registration_fee, 2, ',', '.') }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">

                                    <!-- 👇 LINK 'EDITAR' CORRIGIDO 👇 -->
                                    <a href="{{ route('events.edit', $event->id) }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-100">Editar</a>

                                    <!-- (Vamos adicionar o 'Deletar' aqui depois) -->
                                </td>
                                <!-- ... dentro da <td> de Ações ... -->

                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">

                                    <!-- Link de Editar (você já tem) -->
                                    <a href="{{ route('events.edit', $event->id) }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-100">Editar</a>

                                    <!-- 👇 ADICIONE ESTE FORMULÁRIO 👇 -->
                                    <form method="POST" action="{{ route('events.destroy', $event->id) }}" class="inline-block ml-4" onsubmit="return confirm('Tem certeza que deseja excluir este evento? Esta ação não pode ser desfeita.');">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-100">
                                            Excluir
                                        </button>
                                    </form>
                                    <!-- Fim do formulário adicionado -->

                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400 text-center">
                                    Você ainda não criou nenhum evento.
                                </td>
                            </tr>
                            @endforelse

                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>