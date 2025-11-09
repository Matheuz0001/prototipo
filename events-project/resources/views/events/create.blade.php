<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Criar Novo Evento') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <form method="POST" action="{{ route('events.store') }}">
                        @csrf <div>
                            <x-input-label for="title" :value="__('Título do Evento')" />
                            <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" required autofocus />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="description" :value="__('Descrição')" />
                            <textarea id="description" name="description" rows="4" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('description') }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="location" :value="__('Local')" />
                            <x-text-input id="location" class="block mt-1 w-full" type="text" name="location" :value="old('location')" />
                            <x-input-error :messages="$errors->get('location')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="event_date" :value="__('Data e Hora do Evento')" />
                            <x-text-input id="event_date" class="block mt-1 w-full" type="datetime-local" name="event_date" :value="old('event_date')" required />
                            <x-input-error :messages="$errors->get('event_date')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="registration_deadline" :value="__('Prazo Limite para Inscrição')" />
                            <x-text-input id="registration_deadline" class="block mt-1 w-full" type="datetime-local" name="registration_deadline" :value="old('registration_deadline')" required />
                            <x-input-error :messages="$errors->get('registration_deadline')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="registration_fee" :value="__('Taxa de Inscrição (R$)')" />
                            <x-text-input id="registration_fee" class="block mt-1 w-full" type="number" step="0.01" name="registration_fee" :value="old('registration_fee', 0.00)" required />
                            <x-input-error :messages="$errors->get('registration_fee')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="max_participants" :value="__('Máximo de Participantes (deixe em branco para ilimitado)')" />
                            <x-text-input id="max_participants" class="block mt-1 w-full" type="number" name="max_participants" :value="old('max_participants')" />
                            <x-input-error :messages="$errors->get('max_participants')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="pix_key" :value="__('Chave Pix (para pagamento)')" />
                            <x-text-input id="pix_key" class="block mt-1 w-full" type="text" name="pix_key" :value="old('pix_key')" />
                            <x-input-error :messages="$errors->get('pix_key')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ms-4">
                                {{ __('Salvar Evento') }}
                            </x-primary-button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>