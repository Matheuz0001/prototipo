<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Inscrever-se em: <span class="text-indigo-600 dark:text-indigo-400">{{ $event->title }}</span>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <h3 class="text-lg font-semibold">Passo 2 de 2: Selecione sua modalidade</h3>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        Escolha o tipo de inscrição que deseja para este evento.
                    </p>

                    <form method="POST" action="{{ route('inscriptions.store', $event->id) }}" class="mt-6">
                        @csrf

                        <!-- Lista de Tipos de Inscrição (Modalidades) -->
                        <div>
                            <x-input-label for="inscription_type_id" :value="__('Modalidade de Inscrição')" />
                            
                            @if ($inscriptionTypes->isEmpty())
                                <p class="mt-2 text-red-600 dark:text-red-400">O organizador ainda não cadastrou nenhuma modalidade de inscrição para este evento.</p>
                            @else
                                <select id="inscription_type_id" name="inscription_type_id" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required>
                                    <option value="" disabled selected>{{ __('Selecione uma opção') }}</option>
                                    
                                    @foreach ($inscriptionTypes as $type)
                                        <option value="{{ $type->id }}">
                                            {{ $type->type }}
                                            @if($type->allow_work_submission)
                                                (Permite submissão de trabalho)
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                            @endif
                            <x-input-error :messages="$errors->get('inscription_type_id')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('events.public.show', $event->id) }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                                {{ __('Voltar') }}
                            </a>

                            <!-- 👇 ESTA É A LINHA CORRIGIDA 👇 -->
                            <x-primary-button class="ms-4" :disabled="$inscriptionTypes->isEmpty()">
                                {{ __('Confirmar Inscrição') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>