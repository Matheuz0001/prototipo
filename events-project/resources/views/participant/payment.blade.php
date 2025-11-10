<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Pagamento da Inscrição') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <h3 class="text-2xl font-bold mb-6">Pagar Evento: {{ $inscription->event->title }}</h3>
                    
                    <!-- Passo 1: Informações de Pagamento (PIX) -->
                    <div class="mb-8 border-b pb-6 border-gray-200 dark:border-gray-700">
                        <h4 class="text-lg font-semibold mb-3 text-indigo-600 dark:text-indigo-400">
                            Método: PIX - Copia e Cola
                        </h4>
                        
                        <!-- 
                        👇 ESTA É A LINHA CORRIGIDA 👇
                        Ela agora pega o preço do TIPO de inscrição (Autor, Ouvinte, etc.)
                        -->
                        <p class="text-xl font-bold mb-2">Valor a Pagar: R$ {{ number_format($inscription->inscriptionType->price, 2, ',', '.') }}</p>
                        
                        @if ($inscription->event->pix_key)
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                Copie a chave abaixo para realizar o pagamento via PIX.
                            </p>
                            <div class="mt-3 p-3 bg-gray-100 dark:bg-gray-700 rounded-md flex justify-between items-center break-all">
                                <span class="font-mono text-base text-gray-800 dark:text-gray-100">{{ $inscription->event->pix_key }}</span>
                                <!-- Botão de Copiar (Apenas visual, o JS não está implementado aqui, mas indica a funcionalidade) -->
                                <button type="button" onclick="document.getElementById('pix_key_to_copy').select(); document.execCommand('copy'); alert('Chave PIX copiada para a área de transferência!');" class="ml-4 px-3 py-1 bg-gray-300 dark:bg-gray-600 text-gray-800 dark:text-gray-200 text-sm font-medium rounded hover:bg-gray-400 dark:hover:bg-gray-500">
                                    Copiar
                                </button>
                                <input type="text" id="pix_key_to_copy" value="{{ $inscription->event->pix_key }}" style="position: absolute; left: -9999px;" readonly>
                            </div>
                        @else
                            <p class="mt-3 text-red-500">O organizador não informou a Chave PIX. Por favor, entre em contato.</p>
                        @endif
                    </div>
                    
                    <!-- Passo 2: Envio do Comprovativo -->
                    <h4 class="text-lg font-semibold mb-3">2. Enviar Comprovante (RF-F2)</h4>
                    
                    <!-- O formulário precisa do enctype="multipart/form-data" para upload de arquivos -->
                    <form method="POST" action="{{ route('payment.store', $inscription->id) }}" enctype="multipart/form-data">
                        @csrf

                        <!-- Campo do Arquivo -->
                        <div>
                            <x-input-label for="proof" :value="__('Comprovante de Pagamento (Imagem ou PDF)')" />
                            <!-- Aqui usamos um input HTML nativo para o tipo file -->
                            <input id="proof" name="proof" type="file" required class="block w-full text-sm text-gray-500
                                file:me-4 file:py-2 file:px-4
                                file:rounded-lg file:border-0
                                file:text-sm file:font-semibold
                                file:bg-indigo-600 file:text-white
                                file:hover:bg-indigo-700 dark:file:bg-indigo-700 dark:file:hover:bg-indigo-600
                                mt-1"
                            >
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Tipos permitidos: JPG, PNG, PDF (Máx. 2MB)</p>
                            <x-input-error :messages="$errors->get('proof')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('dashboard') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                                {{ __('Voltar ao Painel') }}
                            </a>

                            <x-primary-button class="ms-4">
                                {{ __('Enviar Comprovante') }}
                            </x-primary-button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>