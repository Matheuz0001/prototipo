<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-900 leading-tight">
            {{ __('Avaliar Trabalho') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- 
              👇 Estilo "Premium" (shadow-xl e rounded-2xl) 👇
            -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl">
                <div class="p-6 md:p-8 text-slate-900">

                    <!-- Detalhes do Trabalho -->
                    <div class="border-b border-slate-200 pb-6">
                        <h3 class="text-2xl font-bold">{{ $review->work->title }}</h3>
                        <p class="text-sm text-slate-500 mt-1">Autor: {{ $review->work->user->name }}</p>
                        
                        <div class="mt-4">
                            <h4 class="font-semibold">Resumo (Abstract)</h4>
                            <p class="text-slate-600 whitespace-pre-line">{{ $review->work->abstract }}</p>
                        </div>

                        <div class="mt-4">
                            <!-- (Precisamos adicionar a rota de download ao WorkController) -->
                            <a href="{{ route('works.download', $review->work) }}" class="inline-block px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md shadow-sm hover:bg-blue-700">
                                Baixar Trabalho (PDF/DOC)
                            </a>
                        </div>
                    </div>

                    <!-- Formulário de Avaliação -->
                    <form method="POST" action="{{ route('reviews.update', $review) }}" class="mt-6">
                        @csrf
                        @method('PATCH') <!-- Usamos PATCH para atualização -->

                        <!-- Status (Aprovado/Reprovado) -->
                        <div>
                            <x-input-label for="status" :value="__('Parecer da Avaliação')" />
                            <select id="status" name="status" class="block mt-1 w-full border-slate-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm" required>
                                <option value="" disabled selected>Selecione um parecer...</option>
                                <option value="1">Aprovado</option>
                                <option value="2">Reprovado</option>
                            </select>
                            <x-input-error :messages="$errors->get('status')" class="mt-2" />
                        </div>

                        <!-- Comentários -->
                        <div class="mt-4">
                            <x-input-label for="comments" :value="__('Comentários (Justificativa para o autor)')" />
                            <textarea id="comments" name="comments" rows="6" class="block mt-1 w-full border-slate-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm" required>{{ old('comments') }}</textarea>
                            <x-input-error :messages="$errors->get('comments')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('dashboard') }}" class="text-sm text-slate-600 hover:text-slate-900 rounded-md">
                                {{ __('Cancelar') }}
                            </a>
                            <x-primary-button class="ms-4">
                                {{ __('Enviar Avaliação') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>