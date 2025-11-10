<x-app-layout>
    <x-slot name="header">
        <!-- Corrigido para o modo claro -->
        <h2 class="font-semibold text-xl text-slate-900 leading-tight">
            {{ __('Gerenciar Trabalhos Submetidos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Corrigido para o modo claro (bg-white) -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-slate-900">

                    @forelse ($works as $work)
                        <!-- Corrigido para o modo claro (border-slate-300) -->
                        <div class="mb-6 p-4 border border-slate-300 rounded-lg">
                            
                            <!-- Detalhes do Trabalho -->
                            <h3 class="text-xl font-bold">{{ $work->title }}</h3>
                            <p class="text-sm text-slate-500">Autor: {{ $work->user->name }} | Tipo: {{ $work->workType->type }}</p>
                            <!-- Corrigido para o modo claro (text-blue-600) -->
                            <a href="{{ route('works.download', $work) }}" class="text-blue-600 hover:text-blue-800 text-sm">
                                Baixar Trabalho
                            </a>

                            <!-- Avaliadores Já Atribuídos -->
                            <div class="mt-4">
                                <h4 class="font-semibold">Avaliadores Atribuídos:</h4>
                                @forelse ($work->reviews as $review)
                                    <!-- Corrigido para o modo claro (bg-slate-200) -->
                                    <span class="inline-block bg-slate-200 text-slate-700 text-xs font-medium me-2 px-2.5 py-0.5 rounded">
                                        {{ $review->user->name }} 
                                        @if($review->status == 0) (Pendente) @endif
                                        @if($review->status == 1) (Aprovado) @endif
                                        @if($review->status == 2) (Reprovado) @endif
                                    </span>
                                @empty
                                    <p class="text-sm text-slate-500">Nenhum avaliador atribuído ainda.</p>
                                @endforelse
                            </div>

                            <!-- Formulário de Atribuição -->
                            <form method="POST" action="{{ route('submissions.assign', $work) }}" class="mt-4 flex items-center space-x-2">
                                @csrf
                                <!-- Corrigido para o modo claro -->
                                <select name="user_id" class="block w-full md:w-1/2 border-slate-300 bg-white text-slate-900 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm" required>
                                    <option value="" disabled selected>Selecione um Avaliador...</option>
                                    @foreach ($reviewers as $reviewer)
                                        <option value="{{ $reviewer->id }}">{{ $reviewer->name }}</option>
                                    @endforeach
                                </select>
                                
                                <x-primary-button>
                                    Atribuir
                                </x-primary-button>
                            </form>
                        </div>
                    @empty
                        <p>Nenhum trabalho foi submetido para seus eventos ainda.</p>
                    @endforelse

                </div>
            </div>
        </div>
    </div>
</x-app-layout>