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

            <!-- ===== SEÇÃO DE INSCRIÇÕES (COM BOTÃO DE SUBMISSÃO) ===== -->
            @if(Auth::user()->user_type_id == 1)
                <div class="mt-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="text-lg font-semibold mb-4">Minhas Inscrições</h3>

                        @forelse($userInscriptions ?? [] as $inscription)
                            <div class="card mb-3" style="border: 1px solid #ddd; padding: 10px; border-radius: 5px;">
                                <div class="card-body">
                                    <h5 class="card-title font-bold">{{ $inscription->event->title }}</h5>
                                    
                                    <!-- ÁREA DE STATUS/AÇÃO -->
                                    <p class="card-text mb-2">
                                        Status: 
                                        
                                        @if($inscription->status == 1)
                                            <span class="badge bg-success" style="color: green;">Confirmada</span>

                                        @elseif($inscription->payment && $inscription->payment->status == 1)
                                            <span class="badge bg-warning" style="color: orange;">Pagamento em Análise</span>
                                            <small style="display: block; margin-top: 5px;">Seu comprovante foi enviado e está aguardando aprovação.</small>

                                        @elseif($inscription->payment && $inscription->payment->status == 3)
                                            <span class="badge bg-danger" style="color: red;">Pagamento Recusado</span>
                                            <small style="display: block; margin-top: 5px;">Motivo: {{ $inscription->payment->rejection_reason ?? 'Não especificado' }}</small>
                                            
                                            <a href="{{ route('payment.create', $inscription) }}" 
                                               class="text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5" 
                                               style="display: inline-block; margin-top: 10px; text-decoration: none;">
                                                Enviar Novo Comprovante
                                            </a>

                                        @else
                                            <span class="badge bg-info" style="color: #0d6efd;">Aguardando Pagamento</span>
                                            
                                            <a href="{{ route('payment.create', $inscription) }}" 
                                               class="text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5" 
                                               style="display: inline-block; margin-top: 10px; text-decoration: none;">
                                                Realizar Pagamento
                                            </a>
                                        @endif
                                    </p>
                                    
                                    <!-- ÁREA DE LINKS DO EVENTO -->
                                    <a href="{{ route('events.public.show', $inscription->event) }}" class="text-indigo-600 hover:text-indigo-900 mt-2" style="display: block;">
                                        Ver detalhes do evento
                                    </a>

                                    <!-- 
                                    👇👇 BLOCO DE SUBMISSÃO DE TRABALHO ADICIONADO 👇👇
                                    -->
                                    @if($inscription->status == 1 && $inscription->inscriptionType->allow_work_submission)
                                        <div class="mt-4 pt-4 border-t dark:border-gray-700">
                                            @if($inscription->work_id)
                                                {{-- O usuário já submeteu --}}
                                                <p class="font-semibold text-green-600">Trabalho submetido com sucesso!</p>
                                                <small>(Título: {{ $inscription->work->title }})</small>
                                                {{-- Futuramente, adicionar botão de "Ver/Editar Trabalho" --}}
                                            @else
                                                {{-- O usuário pode submeter --}}
                                                <a href="{{ route('works.create', $inscription->event) }}" 
                                                   class="text-white bg-gray-700 hover:bg-gray-800 font-medium rounded-lg text-sm px-5 py-2.5" 
                                                   style="display: inline-block; text-decoration: none;">
                                                    Submeter Trabalho
                                                </a>
                                            @endif
                                        </div>
                                    @endif
                                    <!-- 
                                    ☝️☝️ FIM DO BLOCO DE SUBMISSÃO ☝️☝️
                                    -->
                                    
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