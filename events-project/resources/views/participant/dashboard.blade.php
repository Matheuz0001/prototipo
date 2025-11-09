<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Painel do Participante') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Mensagens de Sucesso/Erro -->
            @if (session('success'))
                <div class="mb-6 p-4 bg-green-100 dark:bg-green-900 border border-green-200 dark:border-green-700 text-green-700 dark:text-green-100 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="mb-6 p-4 bg-red-100 dark:bg-red-900 border border-red-200 dark:border-red-700 text-red-700 dark:text-red-100 rounded-lg">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold">{{ __('Minhas Inscrições') }}</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                        Abaixo estão todos os eventos em que você se inscreveu.
                    </p>

                    <!-- Tabela/Lista de Inscrições -->
                    <div class="space-y-4">
                        @forelse ($inscriptions as $inscription)
                            <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 flex flex-col md:flex-row justify-between items-start md:items-center">
                                
                                <!-- Detalhes do Evento -->
                                <div>
                                    <h4 class="text-xl font-bold text-gray-900 dark:text-gray-100">{{ $inscription->event->title }}</h4>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">
                                        Modalidade: <span class="font-semibold">{{ $inscription->inscriptionType->type }}</span>
                                    </p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">
                                        Data do Evento: {{ \Carbon\Carbon::parse($inscription->event->event_date)->format('d/m/Y') }}
                                    </p>
                                </div>

                                <!-- Status e Ações -->
                                <div class="mt-4 md:mt-0 md:text-right">
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">Taxa: R$ {{ number_format($inscription->event->registration_fee, 2, ',', '.') }}</p>
                                    
                                    <!-- LÓGICA DO STATUS (RF-F7) -->
                                    
                                    @if ($inscription->payment && $inscription->payment->status == 1) <!-- Status 1 = Em Análise/Enviado (payments.status) -->
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-200">
                                            Pagamento em Análise
                                        </span>
                                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Comprovante enviado em: {{ \Carbon\Carbon::parse($inscription->payment->created_at)->format('d/m/Y') }}</p>

                                    @elseif ($inscription->status == 1) <!-- 1 = Confirmada (Aprovado pelo organizador - inscriptions.status) -->
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                            Inscrição Confirmada
                                        </span>
                                        <!-- Botão para atividades/certificado -->
                                    
                                    @elseif ($inscription->status == 2) <!-- 2 = Recusada (Inscrição Recusada) -->
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                            Pagamento Recusado
                                        </span>
                                        <p class="text-xs text-red-600 dark:text-red-400 mt-1">Motivo: {{ Str::limit($inscription->payment->rejection_reason ?? 'Não informado', 30) }}</p>
                                        <!-- Link para reenviar comprovativo (RF-F3) -->
                                        <a href="{{ route('payment.create', $inscription->id) }}" class="mt-2 inline-flex items-center px-4 py-2 bg-yellow-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-500">
                                            Reenviar Comprovante
                                        </a>

                                    @elseif ($inscription->status == 0) <!-- 0 = Pendente (Se não houver registro de payment) -->
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                                            Aguardando Pagamento
                                        </span>
                                        <!-- Botão RF-F2 (Enviar Comprovante) -->
                                        <a href="{{ route('payment.create', $inscription->id) }}" class="mt-2 inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                            Pagar / Enviar Comprovante
                                        </a>

                                    @else <!-- 3 = Cancelada ou outros -->
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200">
                                            Status: {{ $inscription->status == 3 ? 'Cancelada' : 'Desconhecido' }}
                                        </span>
                                    @endif
                                    
                                </div>
                            </div>
                        @empty
                            <div class="text-center text-gray-500 dark:text-gray-400 py-6">
                                Você ainda não se inscreveu em nenhum evento.
                            </div>
                        @endforelse
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>