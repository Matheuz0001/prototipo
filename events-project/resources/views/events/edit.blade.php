<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Editar Evento') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Mensagem de Sucesso (para quando adicionar/editar atividade ou tipo) -->
            @if (session('success'))
                <div class="p-4 bg-green-100 dark:bg-green-900 border border-green-200 dark:border-green-700 text-green-700 dark:text-green-100 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif
            
            <!-- Card 1: Formulário de Edição do Evento -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    <form method="POST" action="{{ route('events.update', $event->id) }}">
                        @csrf
                        @method('PUT')
                        
                        <!-- Título -->
                        <div>
                            <x-input-label for="title" :value="__('Título do Evento')" />
                            <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title', $event->title)" required autofocus />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        <!-- Descrição -->
                        <div class="mt-4">
                            <x-input-label for="description" :value="__('Descrição')" />
                            <textarea id="description" name="description" rows="4" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">{{ old('description', $event->description) }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <!-- Local -->
                        <div class="mt-4">
                            <x-input-label for="location" :value="__('Local')" />
                            <x-text-input id="location" class="block mt-1 w-full" type="text" name="location" :value="old('location', $event->location)" />
                            <x-input-error :messages="$errors->get('location')" class="mt-2" />
                        </div>

                        <!-- Data do Evento -->
                        <div class="mt-4">
                            <x-input-label for="event_date" :value="__('Data e Hora do Evento')" />
                            <x-text-input id="event_date" class="block mt-1 w-full" type="datetime-local" name="event_date" :value="old('event_date', \Carbon\Carbon::parse($event->event_date)->format('Y-m-d\TH:i'))" required />
                            <x-input-error :messages="$errors->get('event_date')" class="mt-2" />
                        </div>

                        <!-- Prazo de Inscrição -->
                        <div class="mt-4">
                            <x-input-label for="registration_deadline" :value="__('Prazo Limite para Inscrição')" />
                            <x-text-input id="registration_deadline" class="block mt-1 w-full" type="datetime-local" name="registration_deadline" :value="old('registration_deadline', \Carbon\Carbon::parse($event->registration_deadline)->format('Y-m-d\TH:i'))" required />
                            <x-input-error :messages="$errors->get('registration_deadline')" class="mt-2" />
                        </div>

                        <!-- Taxa de Inscrição -->
                        <div class="mt-4">
                            <x-input-label for="registration_fee" :value="__('Taxa de Inscrição (R$)')" />
                            <x-text-input id="registration_fee" class="block mt-1 w-full" type="number" step="0.01" name="registration_fee" :value="old('registration_fee', $event->registration_fee)" required />
                            <x-input-error :messages="$errors->get('registration_fee')" class="mt-2" />
                        </div>

                        <!-- Máx. Participantes -->
                        <div class="mt-4">
                            <x-input-label for="max_participants" :value="__('Máximo de Participantes (deixe em branco para ilimitado)')" />
                            <x-text-input id="max_participants" class="block mt-1 w-full" type="number" name="max_participants" :value="old('max_participants', $event->max_participants)" />
                            <x-input-error :messages="$errors->get('max_participants')" class="mt-2" />
                        </div>

                        <!-- Chave Pix -->
                        <div class="mt-4">
                            <x-input-label for="pix_key" :value="__('Chave Pix (para pagamento)')" />
                            <x-text-input id="pix_key" class="block mt-1 w-full" type="text" name="pix_key" :value="old('pix_key', $event->pix_key)" />
                            <x-input-error :messages="$errors->get('pix_key')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ms-4">
                                {{ __('Atualizar Evento') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- CARD 2: GERENCIAR PROGRAMAÇÃO (RF-F8) -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold">{{ __('Programação (Atividades)') }}</h3>
                        <a href="{{ route('activities.create', $event->id) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                            {{ __('Adicionar Atividade') }}
                        </a>
                    </div>

                    <div class="mt-4">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Atividade</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Horário</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Ações</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($event->activities as $activity)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $activity->title }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                            {{ \Carbon\Carbon::parse($activity->start_time)->format('d/m H:i') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="{{ route('activities.edit', $activity->id) }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-100">Editar</a>
                                            
                                            <form method="POST" action="{{ route('activities.destroy', $activity->id) }}" class="inline-block ml-4" onsubmit="return confirm('Tem certeza que deseja excluir esta atividade?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-100">
                                                    Excluir
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400 text-center">
                                            Nenhuma atividade cadastrada para este evento.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- CARD 3: GERENCIAR TIPOS DE INSCRIÇÃO (RF-B3) (Novo) -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold">{{ __('Tipos de Inscrição (Modalidades)') }}</h3>
                        <a href="{{ route('inscription_types.create', $event->id) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                            {{ __('Adicionar Tipo') }}
                        </a>
                    </div>

                    <div class="mt-4">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Tipo</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Permite Submissão</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Ações</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($event->inscriptionTypes as $type)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $type->type }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                            {{ $type->allow_work_submission ? 'Sim' : 'Não' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="{{ route('inscription_types.edit', $type->id) }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-100">Editar</a>
                                            
                                            <form method="POST" action="{{ route('inscription_types.destroy', $type->id) }}" class="inline-block ml-4" onsubmit="return confirm('Tem certeza que deseja excluir este tipo de inscrição?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-100">
                                                    Excluir
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400 text-center">
                                            Nenhum tipo de inscrição cadastrado.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- ====== FIM DO CARD 3 ====== -->

        </div>
    </div>
</x-app-layout>