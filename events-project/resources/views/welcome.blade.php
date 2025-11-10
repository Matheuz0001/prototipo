<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonte "Inter" -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

        <!-- TailwindCSS (via CDN) -->
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                darkMode: 'class',
                theme: {
                    extend: {
                        fontFamily: {
                            sans: ['Inter', 'sans-serif'],
                        },
                        colors: {
                            // Paleta "Slate" (Ajustada para ser mais clara)
                            slate: {
                                50: '#f8fafc',
                                100: '#f1f5f9',
                                200: '#e2e8f0',
                                300: '#cbd5e1',
                                400: '#94a3b8',
                                500: '#64748b',
                                600: '#475569',
                                700: '#334155', // Fundo dos Cards (antes 800)
                                800: '#1e293b', // Fundo Principal (antes 900)
                                900: '#0f172a', // Fundo das Seções (antes 950)
                                950: '#020617',
                            },
                        }
                    }
                }
            }
        </script>
        
        <style>
            @media (prefers-color-scheme: dark) {
                :root {
                    color-scheme: dark;
                }
            }
        </style>
    </head>
    
    <!-- 
      CORREÇÃO DE COR:
      Fundo principal agora é 'slate-800' (mais claro)
    -->
    <body class="font-sans antialiased bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100">
        
        <script>
            if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        </script>

        <!-- Header -->
        <header class="fixed top-0 left-0 right-0 z-50">
            <!-- 
              CORREÇÃO DE LAYOUT:
              'classs' -> 'class' (Isso corrige o alinhamento dos botões)
              
              CORREÇÃO DE COR:
              'dark:bg-slate-900/70' -> 'dark:bg-slate-800/70' (Blur mais claro)
            -->
            <nav class="flex justify-between items-center max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-5 bg-white/70 dark:bg-slate-800/70 backdrop-blur-md rounded-b-xl shadow-sm">
                
                <!-- 
                  CORREÇÃO DE LOGO:
                  Ícone 'w-10 h-10' (maior)
                  Texto 'text-2xl' (maior)
                -->
                <a href="/" class="flex items-center space-x-3">
                    <svg class="w-10 h-10 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .522v13.5a8.967 8.967 0 003-.522c1.052 0 2.062.18 3 .522v-1.28a8.967 8.967 0 01-3-.522v-1.28c1.052 0 2.062.18 3 .522m0 0V7.5a8.967 8.967 0 00-3-.522M18 6.042A8.967 8.967 0 0012 3.75c-1.052 0-2.062.18-3 .522m9 13.5a8.967 8.967 0 00-3-.522c-1.052 0-2.062.18-3 .522m6 0v-1.28a8.967 8.967 0 00-3-.522v-1.28c1.052 0 2.062.18 3 .522m-3 0v-1.28a8.967 8.967 0 00-3-.522V7.5a8.967 8.967 0 013-.522M15 18.75V15" />
                    </svg>
                    <span class="font-bold text-2xl text-slate-800 dark:text-slate-200">Fatec Eventos</span>
                </a>

                <!-- 
                  CORREÇÃO DE LAYOUT:
                  Este 'div' agora ficará alinhado à direita graças à correção no 'nav'
                -->
                <div class="flex items-center space-x-4">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="px-5 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:focus:ring-blue-800">
                                Painel
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="text-sm font-medium text-slate-700 dark:text-slate-300 hover:text-blue-600 dark:hover:text-blue-400">
                                Log in
                            </a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="px-5 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:focus:ring-blue-800">
                                    Registrar
                                </a>
                            @endif
                        @endauth
                    @endif
                </div>
            </nav>
        </header>

        <!-- Conteúdo Principal -->
        <main>
            <!-- 1. Seção Hero (Estilo Apple) -->
            <section class="min-h-[70vh] flex items-center pt-32 pb-20">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                    <!-- 
                      CORREÇÃO DE COR:
                      Texto do 'Hero' (branco e azul)
                    -->
                    <h1 class="text-5xl md:text-7xl lg:text-8xl font-extrabold text-slate-900 dark:text-slate-50 mb-6">
                        <span class="block">Plataforma de Eventos</span>
                        <span class="block text-blue-600 dark:text-blue-500">Inteligente & Fluida.</span>
                    </h1>
                    <p class="max-w-2xl mx-auto text-lg md:text-xl text-slate-600 dark:text-slate-300 mb-10">
                        De acadêmicos a corporativos, nossa plataforma simplifica cada etapa. Crie, gerencie, inscreva-se e participe. Tudo em um só lugar.
                    </p>
                    <a href="#eventos" class="px-8 py-3 text-lg font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:focus:ring-blue-800">
                        Ver Eventos Abertos
                    </a>
                </div>
            </section>

            <!-- 2. Seção de Eventos -->
            <!-- 
              CORREÇÃO DE COR:
              Fundo da seção 'slate-900' (um pouco mais escuro que o fundo principal)
            -->
            <section id="eventos" class="py-24 bg-slate-100 dark:bg-slate-900">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="text-center mb-16">
                        <h2 class="text-4xl md:text-5xl font-extrabold text-slate-900 dark:text-slate-50 mb-4">
                            Eventos com Inscrições Abertas
                        </h2>
                        <p class="max-w-xl mx-auto text-lg text-slate-600 dark:text-slate-300">
                            Encontre o próximo evento que vai impulsionar sua carreira.
                        </p>
                    </div>

                    <!-- Grid de Eventos -->
                    @if (isset($events) && $events->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                            
                            <!-- 
                              Card de Evento (Estilo moderno)
                              CORREÇÃO DE COR:
                              Fundo do card 'slate-700' (mais claro que a seção)
                            -->
                            @foreach ($events as $event)
                                <a href="{{ route('events.public.show', $event) }}" class="block bg-white dark:bg-slate-700 rounded-xl shadow-lg overflow-hidden transition-all duration-300 ease-in-out hover:shadow-2xl hover:scale-[1.03]">
                                    <!-- Imagem (Placeholder) -->
                                    <div class="h-48 bg-slate-200 dark:bg-slate-600 flex items-center justify-center">
                                        <svg class="w-16 h-16 text-slate-400 dark:text-slate-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                          <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                                        </svg>
                                    </div>
                                    
                                    <div class="p-6">
                                        <!-- Data do Evento (Tag) -->
                                        <p class="text-sm font-semibold text-blue-600 dark:text-blue-400 mb-2">
                                            {{ \Carbon\Carbon::parse($event->event_date)->format('d \d\e M \d\e Y') }}
                                        </p>
                                        
                                        <!-- Título -->
                                        <h3 class="text-2xl font-bold text-slate-900 dark:text-slate-50 mb-3">
                                            {{ $event->title }}
                                        </h3>
                                        
                                        <!-- Local -->
                                        <p class="text-slate-600 dark:text-slate-300 mb-5">
                                            <svg class="w-4 h-4 inline-block mr-1 -mt-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                              <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                              <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                                            </svg>
                                            {{ $event->location }}
                                        </p>

                                        <!-- Preço (Lógica) -->
                                        @if($event->registration_fee > 0)
                                            <span class="text-xl font-bold text-slate-800 dark:text-slate-50">
                                                R$ {{ number_format($event->registration_fee, 2, ',', '.') }}
                                            </span>
                                        @else
                                            <span class="text-xl font-bold text-green-600 dark:text-green-500">
                                                Gratuito
                                            </span>
                                        @endif
                                    </div>
                                </a>
                            @endforeach

                        </div>
                    @else
                        <div class="text-center bg-white dark:bg-slate-700 rounded-xl p-10 shadow-lg">
                            <h3 class="text-2xl font-bold mb-4 dark:text-slate-50">Nenhum evento por enquanto</h3>
                            <p class="text-slate-600 dark:text-slate-300">
                                Fique atento! Novos eventos serão publicados em breve.
                            </p>
                        </div>
                    @endif
                </div>
            </section>
        </main>

        <!-- Footer -->
        <footer class="bg-white dark:bg-slate-800 border-t border-slate-200 dark:border-slate-700">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                <div class="flex justify-between items-center">
                    <p class="text-sm text-slate-500 dark:text-slate-300">
                        &copy; {{ date('Y') }} {{ config('app.name', 'Laravel') }}. Todos os direitos reservados.
                    </p>
                    <p class="text-sm text-slate-500 dark:text-slate-300">
                        Desenvolvido com <span class="text-red-500">&hearts;</span>
                    </p>
                </div>
            </div>
        </footer>

    </body>
</html>