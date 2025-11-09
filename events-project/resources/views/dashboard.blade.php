<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
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

            @if(Auth::user()->user_type_id == 1)
                <div class="mt-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="text-lg font-semibold mb-4">Minhas Inscrições</h3>

                        @forelse($userInscriptions ?? [] as $inscription)
                            <div class="card mb-3" style="border: 1px solid #ddd; padding: 10px; border-radius: 5px;">
                                <div class="card-body">
                                    <h5 class="card-title font-bold">{{ $inscription->event->title }}</h5>
                                    
                                    <p class="card-text">
                                        Status: 
                                        
                                        @if($inscription->status == 1)
                                            {{-- 1. Inscrição já foi confirmada pelo organizador --}}
                                            <span class="badge bg-success" style="color: green;">Confirmada</span>

                                        @elseif($inscription->payment && $inscription->payment->status == 0)
                                            {{-- 2. Já existe um pagamento (comprovante enviado), mas está pendente de aprovação --}}
                                            <span class="badge bg-warning" style="color: orange;">Pagamento em Análise</span>
                                            <small class="d-block">Seu comprovante foi enviado e está aguardando aprovação.</small>

                                        @elseif($inscription->status == 0)
                                            {{-- 3. Inscrição pendente (status 0) e SEM pagamento iniciado --}}
                                            <span class="badge bg-info" style="color: #0d6efd;">Aguardando Pagamento</span>
                                            
                                            {{-- BOTÃO DE PAGAR (usa a rota que já criamos no web.php) --}}
                                            <a href="{{ route('payment.create', $inscription) }}" 
                                               class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800" 
                                               style="display: inline-block; margin-top: 10px; text-decoration: none;">
                                                Realizar Pagamento
                                            </a>
                                        @endif
                                    </p>
                                    <a href="{{ route('events.public.show', $inscription->event) }}" class="text-indigo-600 hover:text-indigo-900 mt-2" style="display: block;">
                                        Ver detalhes do evento
                                    </a>
                                </div>
                            </div>
                        
                        @empty
                            <div class="alert alert-info">
                                Você ainda não possui inscrições.
                            </div>
                        @endforelse

                    </div>
                </div>
            @endif
            </div>
    </div>
</x-app-layout>