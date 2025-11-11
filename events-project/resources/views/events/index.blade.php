<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-900 leading-tight">
            {{ __('Meus Eventos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Botão de Criar Novo Evento -->
            <div class="flex justify-end mb-4">
                <a href="{{ route('events.create') }}"
                   class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 shadow-md">
                    + Criar Novo Evento
                </a>
            </div>

            <!-- 
              estilo
              shadow-sm sm:rounded-lg -> shadow-xl sm:rounded-2xl
            -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl">
                <div class="p-6 text-slate-900">
                    
                    <h3 class="text-lg font-semibold mb-4">Seus Eventos Cadastrados</h3>
                    
                    <!-- Tabela de Eventos -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-slate-200">
                            <thead class="bg-slate-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Título</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Data do Evento</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Taxa (R$)</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Ações</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-slate-200">
                                @forelse ($events as $event)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-slate-900">{{ $event->title }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-slate-600">{{ $event->event_date->format('d/m/Y H:i') }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-slate-600">{{ number_format($event->registration_fee, 2, ',', '.') }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                           
                                            <a href="{{ route('events.edit', $event) }}" class="text-blue-600 hover:text-blue-900">Editar</a>
                                            
                                            <!-- Botão Excluir (com formulário de segurança) -->
                                            <form method="POST" action="{{ route('events.destroy', $event) }}" class="inline-block ml-4" onsubmit="return confirm('Tem certeza que deseja excluir este evento? Esta ação não pode ser desfeita.');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">Excluir</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 whitespace-nowrap text-sm text-slate-500 text-center">
                                            Você ainda não cadastrou nenhum evento.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>