<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-900 leading-tight">
            {{ __('Painel') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- 
              👇 MUDANÇA DE ESTILO "PREMIUM" 👇
              shadow-sm sm:rounded-lg -> shadow-xl sm:rounded-2xl
            -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl">
                <div class="p-6 text-slate-900">
                    {{ __("You're logged in!") }}
                    
                    @if(Auth::user()->user_type_id == 1)
                        <p>Você está logado como <strong>Participante</strong>.</p>
                    @elseif(Auth::user()->user_type_id == 2)
                        <p>Você está logado como <strong>Organizador</strong>.</p>
                    @elseif(Auth::user()->user_type_id == 3)
                        <p>Você está logado como <strong>Avaliador</strong>.</p>
                    @endif
                </div>
            </div>

            <!-- ===== PAINEL DO PARTICIPANTE (ID 1) ===== -->
            @if(Auth::user()->user_type_id == 1)
                <!-- 
                  👇 MUDANÇA DE ESTILO "PREMIUM" 👇
                  shadow-sm sm:rounded-lg -> shadow-xl sm:rounded-2xl
                -->
                <div class="mt-6 bg-white overflow-hidden shadow-xl sm:rounded-2xl">
                    <div class="p-6 text-slate-900">
                        <h3 class="text-lg font-semibold mb-4">Minhas Inscrições</h3>

                        @forelse($userInscriptions ?? [] as $inscription)
                            <div class="card mb-4 p-4 border rounded-lg border-slate-200">
                                <div class="card-body">
                                    <h5 class="card-title font-bold text-lg text-slate-800">{{ $inscription->event->title }}</h5>
                                    
                                    <!-- Área de Status/Ação -->
                                    <div class="card-text mt-2">
                                        <span class="font-medium">Status:</span> 
                                        
                                        @if($inscription->status == 1)
                                            <!-- 1. Confirmada -->
                                            <span class="font-medium text-green-600">Confirmada</span>

                                        @elseif($inscription->payment && $inscription->payment->status == 1)
                                            <!-- 2. Em Análise -->
                                            <span class="font-medium text-orange-600">Pagamento em Análise</span>
                                            <small class="block text-slate-500 mt-1">Seu comprovante foi enviado e está aguardando aprovação.</small>

                                        @elseif($inscription->payment && $inscription->payment->status == 3)
                                            <!-- 3. Recusado -->
                                            <span class="font-medium text-red-600">Pagamento Recusado</span>
                                            <small class="block text-slate-500 mt-1">Motivo: {{ $inscription->payment->rejection_reason ?? 'Não especificado' }}</small>
                                            
                                            <a href="{{ route('payment.create', $inscription) }}" class="inline-block mt-3 px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md shadow-sm hover:bg-blue-700">
                                                Enviar Novo Comprovante
                                            </a>

                                        @else
                                            <!-- 4. Aguardando Pagamento -->
                                            <span class="font-medium text-blue-600">Aguardando Pagamento</span>
                                            <a href="{{ route('payment.create', $inscription) }}" class="inline-block mt-3 px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md shadow-sm hover:bg-blue-700">
                                                Realizar Pagamento
                                            </a>
                                        @endif
                                    </div>
                                    
                                    <!-- Área de Submissão de Trabalho (se houver) -->
                                    <div class="border-t border-slate-200 mt-4 pt-4">
                                        @if($inscription->work_id)
                                            <!-- 3c. Já submeteu -->
                                            <p class="font-medium text-green-600">Trabalho submetido com sucesso!</p>
                                            <small class="block text-slate-500">(Título: {{ $inscription->work->title }})</small>
                                        
                                        @elseif($inscription->status == 1 && $inscription->inscriptionType->allow_work_submission)
                                            <!-- 3a. Pode submeter -->
                                            <a href="{{ route('works.create', $inscription->event) }}" class="inline-block px-4 py-2 text-sm font-medium text-white bg-slate-700 rounded-md shadow-sm hover:bg-slate-800">
                                                Submeter Trabalho
                                            </a>
                                        @elseif($inscription->status != 1 && $inscription->inscriptionType->allow_work_submission)
                                            <!-- 3b. Pagamento pendente -->
                                            <p class="text-sm text-slate-500">A submissão de trabalho será liberada após a confirmação do pagamento.</p>
                                        @endif
                                    </div>

                                </div>
                            </div>
                        
                        @empty
                            <div class="alert alert-info text-slate-600">
                                Você ainda não possui inscrições.
                            </div>
                        @endforelse

                    </div>
                </div>
            @endif
            <!-- ===== FIM DO PAINEL DO PARTICIPANTE ===== -->
            
            
            <!-- ===== PAINEL DO AVALIADOR (ID 3) ===== -->
            @if(Auth::user()->user_type_id == 3)
                <!-- 
                  👇 MUDANÇA DE ESTILO "PREMIUM" 👇
                  shadow-sm sm:rounded-lg -> shadow-xl sm:rounded-2xl
                -->
                <div class="mt-6 bg-white overflow-hidden shadow-xl sm:rounded-2xl">
                    <div class="p-6 text-slate-900">
                        <h3 class="text-lg font-semibold mb-4">Trabalhos Pendentes para Avaliação</h3>

                        @forelse ($pendingReviews ?? [] as $review)
                            <div class="mb-4 p-4 border rounded-lg border-slate-200">
                                <h4 class="font-bold text-lg text-slate-800">{{ $review->work->title }}</h4>
                                <p class="text-sm text-slate-500">Autor: {{ $review->work->user->name }}</p>
                                <p class="text-sm text-slate-500">Submetido em: {{ $review->work->created_at->format('d/m/Y') }}</p>
                                
                                <div class="mt-4">
                                    <a href="{{ route('reviews.edit', $review) }}" class="inline-block px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md shadow-sm hover:bg-blue-700">
                                        Avaliar Trabalho
                                    </a>
                                </div>
                            </div>
                        @empty
                            <p class="text-slate-600">Você não possui trabalhos pendentes para avaliação no momento.</p>
                        @endforelse
                    </div>
                </div>
            @endif
            <!-- ===== FIM DO PAINEL DO AVALIADOR ===== -->

        </div>
    </div>
</x-app-layout>