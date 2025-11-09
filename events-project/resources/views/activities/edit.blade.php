<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Editar Atividade: <span class="text-indigo-600 dark:text-indigo-400">{{ $activity->title }}</span>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    <form method="POST" action="{{ route('activities.update', $activity->id) }}">
                        @csrf
                        @method('PUT')

                        <!-- Título -->
                        <div>
                            <x-input-label for="title" :value="__('Título da Atividade (ex: Palestra, Minicurso)')" />
                            <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title', $activity->title)" required autofocus />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        <!-- Descrição -->
                        <div class="mt-4">
                            <x-input-label for="description" :value="__('Descrição')" />
                            <textarea id="description" name="description" rows="3" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">{{ old('description', $activity->description) }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <!-- Local -->
                        <div class="mt-4">
                            <x-input-label for="location" :value="__('Local (ex: Auditório, Sala 10)')" />
                            <x-text-input id="location" class="block mt-1 w-full" type="text" name="location" :value="old('location', $activity->location)" />
                            <x-input-error :messages="$errors->get('location')" class="mt-2" />
                        </div>

                        <!-- Data/Hora de Início -->
                        <div class="mt-4">
                            <x-input-label for="start_time" :value="__('Data e Hora de Início')" />
                            <x-text-input id="start_time" class="block mt-1 w-full" type="datetime-local" name="start_time" :value="old('start_time', \Carbon\Carbon::parse($activity->start_time)->format('Y-m-d\TH:i'))" required />
                            <x-input-error :messages="$errors->get('start_time')" class="mt-2" />
                        </div>

                        <!-- Data/Hora de Fim -->
                        <div class="mt-4">
                            <x-input-label for="end_time" :value="__('Data e Hora de Fim')" />
                            <x-text-input id="end_time" class="block mt-1 w-full" type="datetime-local" name="end_time" :value="old('end_time', \Carbon\Carbon::parse($activity->end_time)->format('Y-m-d\TH:i'))" required />
                            <x-input-error :messages="$errors->get('end_time')" class="mt-2" />
                        </div>

                        <!-- Máx. Participantes -->
                        <div class="mt-4">
                            <x-input-label for="max_participants" :value="__('Máximo de Participantes (deixe em branco para ilimitado)')" />
                            <x-text-input id="max_participants" class="block mt-1 w-full" type="number" name="max_participants" :value="old('max_participants', $activity->max_participants)" />
                            <x-input-error :messages="$errors->get('max_participants')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <!-- O 'back' link leva para a edição do evento PAI -->
                            <a href="{{ route('events.edit', $activity->event_id) }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                                {{ __('Cancelar') }}
                            </a>
                            
                            <x-primary-button class="ms-4">
                                {{ __('Atualizar Atividade') }}
                            </x-primary-button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>