<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"> <!-- 1. CORRIGIDO -->
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Fatec Eventos</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <!-- 2. CORRIGIDO (URL da fonte estava errada) -->
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js']) <!-- 3. CORRIGIDO (barras \ removidas) -->
</head>
<body class="font-sans antialiased dark:bg-gray-900">
    <div class="bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 min-h-screen">
        <!-- Navegação Superior -->
        <nav class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <!-- Logo -->
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
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="mb-8">
                    <h1 class="text-4xl font-bold text-center text-gray-900 dark:text-gray-100">Eventos com Inscrições Abertas</h1>
                </div>

                <!-- Lista de Eventos (Vinda do routes/web.php) -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    
                    @forelse ($events as $event)
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6">
                                
                                <!-- Este é o link da Etapa 5 -->
                                <h2 class="text-2xl font-bold mb-2">
                                    <a href="{{ route('events.public.show', $event) }}" class="hover:text-blue-600 dark:hover:text-blue-400">
                                        {{ $event->title }}
                                    </a>
                                </h2>

                                <p class="text-gray-700 dark:text-gray-300 mb-4">
                                    {{ Str::limit($event->description, 150) }} <!-- Limita a descrição -->
                                </p>
                                <div class="text-sm text-gray-600 dark:text-gray-400">
                                    <p><strong>Quando:</strong> {{ \Carbon\Carbon::parse($event->event_date)->format('d/m/Y') }}</p>
                                    <p><strong>Onde:</strong> {{ $event->location }}</p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <!-- Mensagem se não houver eventos -->
                        <div class="col-span-full text-center py-10">
                            <p class="text-gray-500 text-lg">Nenhum evento com inscrição aberta no momento.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </main>
    </div>
</body>
</html>