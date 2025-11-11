<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-900 leading-tight">
            {{ __('Criar Novo Evento') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-slate-900">

                    <!-- 1. ADICIONADO O enctype para upload de arquivos -->
                    <form method="POST" action="{{ route('events.store') }}" enctype="multipart/form-data">
                        @csrf

                        <!-- Título -->
                        <div>
                            <x-input-label for="title" :value="__('Título do Evento')" />
                            <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" required autofocus />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        <!-- Descrição -->
                        <div class="mt-4">
                            <x-input-label for="description" :value="__('Descrição Completa')" />
                            <textarea id="description" name="description" rows="5" class="block mt-1 w-full border-slate-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm">{{ old('description') }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <!-- Local -->
                        <div class="mt-4">
                            <x-input-label for="location" :value="__('Local (ou link, se for online)')" />
                            <x-text-input id="location" class="block mt-1 w-full" type="text" name="location" :value="old('location')" required />
                            <x-input-error :messages="$errors->get('location')" class="mt-2" />
                        </div>

                        <!-- Grade de Datas -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                            <div>
                                <x-input-label for="event_date" :value="__('Data e Hora do Evento')" />
                                <x-text-input id="event_date" class="block mt-1 w-full" type="datetime-local" name="event_date" :value="old('event_date')" required />
                                <x-input-error :messages="$errors->get('event_date')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="registration_deadline" :value="__('Prazo Limite de Inscrição')" />
                                <x-text-input id="registration_deadline" class="block mt-1 w-full" type="datetime-local" name="registration_deadline" :value="old('registration_deadline')" required />
                                <x-input-error :messages="$errors->get('registration_deadline')" class="mt-2" />
                            </div>
                        </div>
                        
                        <!-- Grade de Valores -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                            <div>
                                <x-input-label for="registration_fee" :value="__('Taxa de Inscrição (R$)')" />
                                <x-text-input id="registration_fee" class="block mt-1 w-full" type="number" name="registration_fee" :value="old('registration_fee', 0)" required step="0.01" min="0" />
                                <x-input-error :messages="$errors->get('registration_fee')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="max_participants" :value="__('Máx. de Participantes (deixe em branco para ilimitado)')" />
                                <x-text-input id="max_participants" class="block mt-1 w-full" type="number" name="max_participants" :value="old('max_participants')" min="1" />
                                <x-input-error :messages="$errors->get('max_participants')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Chave Pix -->
                        <div class="mt-4">
                            <x-input-label for="pix_key" :value="__('Chave Pix (para pagamento)')" />
                            <x-text-input id="pix_key" class="block mt-1 w-full" type="text" name="pix_key" :value="old('pix_key')" required />
                            <x-input-error :messages="$errors->get('pix_key')" class="mt-2" />
                        </div>
                        
                        <!-- 2. CAMPO DE UPLOAD DE CAPA ADICIONADO -->
                        <div class="mt-6 border-t border-slate-200 pt-6">
                            <x-input-label for="cover_image" :value="__('Capa do Evento (Banner) (JPG, PNG, WEBP - Máx 2MB)')" />
                            <input id="cover_image" name="cover_image" type="file" accept="image/jpeg,image/png,image/jpg,image/webp" class="block w-full text-sm text-slate-500
                                file:me-4 file:py-2 file:px-4
                                file:rounded-lg file:border-0
                                file:text-sm file:font-semibold
                                file:bg-blue-600 file:text-white
                                file:hover:bg-blue-700
                                mt-1"
                            >
                            <x-input-error :messages="$errors->get('cover_image')" class="mt-2" />
                        </div>
                        
                        <div class="flex items-center justify-end mt-6 pt-6 border-t border-slate-200">
                            <a href="{{ route('events.index') }}" class="text-sm text-slate-600 hover:text-slate-900 rounded-md">
                                {{ __('Cancelar') }}
                            </a>
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