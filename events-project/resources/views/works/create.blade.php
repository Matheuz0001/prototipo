<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Submeter Trabalho para: <span class="text-indigo-600 dark:text-indigo-400">{{ $event->title }}</span>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <!-- Formulário precisa de enctype para upload -->
                    <form method="POST" action="{{ route('works.store', $event) }}" enctype="multipart/form-data">
                        @csrf

                        <!-- Título do Trabalho -->
                        <div class="mt-4">
                            <x-input-label for="title" :value="__('Título do Trabalho')" />
                            <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" required />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        <!-- Tipo de Trabalho (Dropdown) -->
                        <div class="mt-4">
                            <x-input-label for="work_type_id" :value="__('Tipo de Trabalho (ex: Artigo, Resumo)')" />
                            <select id="work_type_id" name="work_type_id" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required>
                                <option value="" disabled selected>Selecione um tipo...</option>
                                @foreach($workTypes as $type)
                                    <option value="{{ $type->id }}" {{ old('work_type_id') == $type->id ? 'selected' : '' }}>
                                        {{ $type->type }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('work_type_id')" class="mt-2" />
                        </div>

                        <!-- Orientador -->
                        <div class="mt-4">
                            <x-input-label for="advisor" :value="__('Nome do Orientador')" />
                            <x-text-input id="advisor" class="block mt-1 w-full" type="text" name="advisor" :value="old('advisor')" required />
                            <x-input-error :messages="$errors->get('advisor')" class="mt-2" />
                        </div>

                        <!-- Coautores -->
                        <div class="mt-4">
                            <x-input-label for="co_authors_text" :value="__('Coautores (separados por vírgula)')" />
                            <x-text-input id="co_authors_text" class="block mt-1 w-full" type="text" name="co_authors_text" :value="old('co_authors_text')" />
                            <x-input-error :messages="$errors->get('co_authors_text')" class="mt-2" />
                        </div>
                        
                        <!-- Resumo (Abstract) -->
                        <div class="mt-4">
                            <x-input-label for="abstract" :value="__('Resumo (Abstract)')" />
                            <textarea id="abstract" name="abstract" rows="6" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required>{{ old('abstract') }}</textarea>
                            <x-input-error :messages="$errors->get('abstract')" class="mt-2" />
                        </div>

                        <!-- Upload do Ficheiro -->
                        <div class="mt-4">
                            <x-input-label for="file" :value="__('Ficheiro do Trabalho (PDF, DOC, DOCX - Máx 5MB)')" />
                            <input id="file" name="file" type="file" required class="block w-full text-sm text-gray-500
                                file:me-4 file:py-2 file:px-4 file:rounded-lg file:border-0
                                file:text-sm file:font-semibold file:bg-indigo-600 file:text-white
                                file:hover:bg-indigo-700 dark:file:bg-indigo-700 dark:file:hover:bg-indigo-600 mt-1">
                            <x-input-error :messages="$errors->get('file')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('dashboard') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none">
                                {{ __('Cancelar') }}
                            </a>
                            <x-primary-button class="ms-4">
                                {{ __('Submeter Trabalho') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>