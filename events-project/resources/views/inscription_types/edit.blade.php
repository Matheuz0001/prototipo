<x-app-layout>
    <x-slot name="header">
        <h2 classclass="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Editar Tipo de Inscrição: <span class="text-indigo-600 dark:text-indigo-400">{{ $inscriptionType->type }}</span>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <form method="POST" action="{{ route('inscription_types.update', $inscriptionType->id) }}">
                        @csrf
                        @method('PUT')

                        <div>
                            <x-input-label for="type" :value="__('Nome do Tipo (ex: Ouvinte, Autor, Palestrante)')" />
                            <x-text-input id="type" class="block mt-1 w-full" type="text" name="type" :value="old('type', $inscriptionType->type)" required autofocus />
                            <x-input-error :messages="$errors->get('type')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="price" :value="__('Preço (R$)')" />
                            <x-text-input id="price" 
                                          class="block mt-1 w-full" 
                                          type="number" 
                                          name="price" 
                                          :value="old('price', $inscriptionType->price)" 
                                          required 
                                          step="0.01" 
                                          min="0" />
                            <x-input-error :messages="$errors->get('price')" class="mt-2" />
                        </div>
                        <div class="block mt-4">
                            <label for="allow_work_submission" class="inline-flex items-center">
                                <input id="allow_work_submission" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" name="allow_work_submission" value="1" {{ old('allow_work_submission', $inscriptionType->allow_work_submission) ? 'checked' : '' }}>
                                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Permite submissão de trabalho?') }}</span>
                            </label>
                            <x-input-error :messages="$errors->get('allow_work_submission')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('events.edit', $inscriptionType->event_id) }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                                {{ __('Cancelar') }}
                            </a>
                            
                            <x-primary-button class="ms-4">
                                {{ __('Atualizar Tipo de Inscrição') }}
                            </x-primary-button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>