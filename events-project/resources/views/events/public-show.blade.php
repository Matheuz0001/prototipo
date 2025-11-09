<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $event->title }}</title>
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased dark:bg-gray-900">
        <div class="bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 min-h-screen">
            <!-- Navegação (a mesma da welcome.blade.php) -->
            <nav class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex items-center">
                            <a href="/" class="text-lg font-bold">Fatec Eventos</a>
                        </div>
                        <div class="flex items-center">
                            @if (Route::has('login'))
                                <div class="p-6 text-right">
                                    @auth
                                        <a href="{{ url('/dashboard') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Dashboard</a>
                                    @else
                                        <a href="{{ route('login') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Log in</a>
                                        @if (Route::has('register'))
                                            <a href="{{ route('register') }}" class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Register</a>
                                        @endif
                                    @endauth
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Conteúdo da Página -->
            <main class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
                    
                    <!-- Detalhes do Evento -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h1 class="text-3xl font-bold mb-4">{{ $event->title }}</h1>
                            <p class="text-lg text-gray-700 dark:text-gray-300 mb-6">{{ $event->description }}</p>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div>
                                    <h3 class="text-sm font-medium text-gray-500 uppercase">Quando</h3>
                                    <p class="text-lg">{{ \Carbon\Carbon::parse($event->event_date)->format('d/m/Y \à\s H:i') }}</p>
                                </div>
                                <div>
                                    <h3 class="text-sm font-medium text-gray-500 uppercase">Onde</h3>
                                    <p class="text-lg">{{ $event->location }}</p>
                                </div>
                                <div>
                                    <h3 class="text-sm font-medium text-gray-500 uppercase">Inscrições até</h3>
                                    <p class="text-lg">{{ \Carbon\Carbon::parse($event->registration_deadline)->format('d/m/Y \à\s H:i') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tipos de Inscrição e Atividades (RF-F8) -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Coluna da Inscrição (RF-F1) -->
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6">
                                <h2 class="text-2xl font-bold mb-4">Inscreva-se</h2>
                                <p class="mb-4">Taxa base: <span class="font-bold text-xl">R$ {{ number_format($event->registration_fee, 2, ',', '.') }}</span></p>

                                <h3 class="text-lg font-semibold mb-2">Modalidades de Inscrição:</h3>
                                <ul class="list-disc list-inside mb-4">
                                    @forelse ($event->inscriptionTypes as $type)
                                        <li>{{ $type->type }} 
                                            @if($type->allow_work_submission)
                                                <span class="text-sm text-gray-500">(Permite submissão de trabalho)</span>
                                            @endif
                                        </li>
                                    @empty
                                        <li>Inscrição Padrão (Tipo não especificado pelo organizador)</li>
                                    @endforelse
                                </ul>

                                <!-- O Botão de Inscrição (RF-F1) -->
                                <!-- 👇 ESTA É A LINHA ATUALIZADA 👇 -->
                                <a href="{{ route('inscriptions.create', $event->id) }}" class="inline-flex items-center px-6 py-3 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 w-full text-center justify-center">
                                    Iniciar Inscrição
                                </a>

                            </div>
                        </div>

                        <!-- Coluna das Atividades -->
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6">
                                <h2 class="text-2xl font-bold mb-4">Programação (RF-F8)</h2>
                                @forelse ($event->activities as $activity)
                                    <div class="border-b border-gray-200 dark:border-gray-700 py-3">
                                        <h3 class="font-semibold">{{ $activity->title }}</h3>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ $activity->description }}</p>
                                        <div class="text-sm text-gray-500 mt-1">
                                            <span>{{ \Carbon\Carbon::parse($activity->start_time)->format('d/m H:i') }}</span>
                                            <span>- {{ \Carbon\Carbon::parse($activity->end_time)->format('H:i') }}</span>
                                            <span class="mx-2">|</span>
                                            <span>{{ $activity->location }}</span>
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-gray-500">A programação detalhada será divulgada em breve.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </body>
</html>