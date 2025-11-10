<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-900 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Card "You're logged in" -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-slate-900">
                    {{ __("You're logged in!") }}
                    
                    @if(Auth::user()->user_type_id == 1)
                        <p>Você está logado como **Participante**.</p>
                    @elseif(Auth::user()->user_type_id == 2)
                        <p>Você está logado como **Organizador**.</p>
                    @elseif(Auth::user()->user_type_id == 3)
                        <p>Você está logado como **Avaliador**.</p>
                    @endif
                </div>
            </div>

            <!-- ===== SEÇÃO DO PARTICIPANTE (ID == 1) ===== -->
            @if(Auth::user()->user_type_id == 1)
                <div class="mt-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-slate-900">
                        <h3 class="text-lg font-semibold mb-4">Minhas Inscrições</h3>

                        @forelse($userInscriptions ?? [] as $inscription)
                            <div class="card mb-3 border border-slate-300 p-4 rounded-lg">
                                <div class="card-body">
                                    <h5 class="card-title font-bold text-lg">{{ $inscription->event->title }}</h5>
                                    
                                    <!-- ÁREA DE STATUS/AÇÃO -->
                                    <p class="card-text mb-2">
                                        Status: 
                                        
                                        @if($inscription->status == 1)
                                            <span class="font-medium" style="color: green;">Confirmada</span>
                                        @elseif($inscription->payment && $inscription->payment->status == 1)
                                            <span class="font-medium" style="color: orange;">Pagamento em Análise</span>
                                        @elseif($inscription->payment && $inscription->payment->status == 3)
                                            <span class="font-medium" style="color: red;">Pagamento Recusado</span>
                                            <small style="display: block; margin-top: 5px;">Motivo: {{ $inscription->payment->rejection_reason ?? 'Não especificado' }}</small>
                                            <a href="{{ route('payment.create', $inscription) }}" class="text-white bg-blue-600 hover:bg-blue-700 font-medium rounded-lg text-sm px-5 py-2.5" style="display: inline-block; margin-top: 10px; text-decoration: none;">
                                                Enviar Novo Comprovante
                                            </a>
                                        @else
                                            <span class="font-medium" style="color: #0d6efd;">Aguardando Pagamento</span>
                                            <a href="{{ route('payment.create', $inscription) }}" class="text-white bg-blue-600 hover:bg-blue-700 font-medium rounded-lg text-sm px-5 py-2.5" style="display: inline-block; margin-top: 10px; text-decoration: none;">
                                                Realizar Pagamento
                                            </a>
                                        @endif
                                    </p>
                                    
                                    <a href="{{ route('events.public.show', $inscription->event) }}" class="text-blue-600 hover:text-blue-800 mt-2" style="display: block;">
                                        Ver detalhes do evento
                                    </a>

                                    @if($inscription->status == 1 && $inscription->inscriptionType->allow_work_submission)
                                        <div class="mt-4 pt-4 border-t border-slate-200">
                                            @if($inscription->work_id)
                                                <p class="font-semibold text-green-600">Trabalho submetido com sucesso!</p>
                                                <small>(Título: {{ $inscription->work->title }})</small>
                                            @else
                                                <a href="{{ route('works.create', $inscription->event) }}" class="text-slate-800 bg-slate-200 hover:bg-slate-300 font-medium rounded-lg text-sm px-5 py-2.5" style="display: inline-block; text-decoration: none;">
                                                    Submeter Trabalho
                                                </a>
                                            @endif
                                        </div>
                                    @endif
                                    
                                T</div>
                            </div>
                        @empty
                            <div class="alert alert-info">
                                Você ainda não possui inscrições.
                            </div>
                        @endforelse
                    </div>
                </div>
            @endif
            
            <!-- ===== SEÇÃO DO ORGANIZADOR (ID == 2) ===== -->
            @if(Auth::user()->user_type_id == 2)
                {{-- (Futuramente, adicionar estatísticas do organizador aqui) --}}
            @endif


            <!-- ===== SEÇÃO DO AVALIADOR (ID == 3) ===== -->
            @if(Auth::user()->user_type_id == 3)
                <div class="mt-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-slate-900">
                        <h3 class="text-lg font-semibold mb-4">Trabalhos Pendentes para Avaliação</h3>

                        @forelse($pendingReviews ?? [] as $review)
                            <div class="card mb-3 border border-slate-300 p-4 rounded-lg">
                                <div class="card-body">
                                    <h5 class="card-title font-bold text-lg">{{ $review->work->title }}</h5>
                                    <p class="text-sm">Autor: {{ $review->work->user->name }}</p>
                                    <p class="text-sm">Tipo: {{ $review->work->workType->type }}</p>
                                    
                                    <div class="mt-4">
                                        <a href="#" {{-- route('reviews.edit', $review) --}} 
                                           class="text-white bg-blue-600 hover:bg-blue-700 font-medium rounded-lg text-sm px-5 py-2.5">
                                            Avaliar Trabalho
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="alert alert-info">
                                Você não possui trabalhos pendentes para avaliação.
                            </div>
                        @endforelse
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>