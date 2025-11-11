<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-t8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonte "Inter" -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

        <!-- TailwindCSS (CDN) -->
        <script src="https://cdn.tailwindcss.com"></script>
        
        <!-- Swiper.js (A biblioteca do Carrossel) -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
        <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

        <script>
            // Configuração do Tailwind para usar a fonte "Inter" e a paleta "Blue"
            tailwind.config = {
                theme: {
                    extend: {
                        fontFamily: {
                            sans: ['Inter', 'sans-serif'],
                        },
                        colors: {
                            slate: { 50: '#f8fafc', 100: '#f1f5f9', 200: '#e2e8f0', 300: '#cbd5e1', 400: '#94a3b8', 500: '#64748b', 600: '#475569', 700: '#334155', 800: '#1e293b', 900: '#0f172a', 950: '#020617' },
                            blue: { 50: '#eff6ff', 100: '#dbeafe', 200: '#bfdbfe', 300: '#93c5fd', 400: '#60a5fa', 500: '#3b82f6', 600: '#2563eb', 700: '#1d4ed8', 800: '#1e40af', 900: '#1e3a8a', 950: '#172554' }
                        }
                    }
                }
            }
        </script>
        
        <style>
            /* Estilo para o Swiper.js (Carrossel) */
            /* Isso garante que possamos ver os cards "vizinhos", como na sua referência */
            .swiper-slide {
                width: 75%; /* O card principal ocupa 75% */
                opacity: 0.4; /* Cards laterais ficam opacos */
                transition: opacity 0.3s ease-in-out;
            }
            .swiper-slide-active {
                opacity: 1; /* O card ativo fica 100% visível */
            }
            /* Media query para telas maiores (desktop) */
            @media (min-width: 768px) {
                .swiper-slide {
                    width: 50%; /* No desktop, o card principal ocupa 50% */
                }
            }
        </style>
    </head>
    
    <!-- Fundo 'slate-100' (branco-gelo) e texto 'slate-900' (escuro) -->
    <body class="font-sans antialiased bg-slate-100 text-slate-900">
        
        <!-- Header -->
        <header class="fixed top-0 left-0 right-0 z-50">
            <!-- Navbar com "blur" (efeito Apple) e fundo branco-gelo -->
            <nav class="flex justify-between items-center max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-5 bg-slate-100/80 backdrop-blur-md rounded-b-xl shadow-sm">
                
                <!-- Logo -->
                <a href="/" class="flex items-center space-x-3">
                    <!-- Ícone (SVG de Calendário) -->
                    <svg class="w-8 h-8 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                    </svg>
                    <!-- Texto da Logo (Maior e mais bonito) -->
                    <span class="text-2xl font-bold text-slate-900">Fatec Eventos</span>
                </a>

                <!-- Botões de Login/Registro (Corrigido) -->
                <div class="flex items-center space-x-3">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="px-5 py-2 text-sm font-medium text-slate-700 bg-white rounded-lg shadow-sm hover:bg-slate-50">Painel</a>
                        @else
                            <a href="{{ route('login') }}" class="px-5 py-2 text-sm font-medium text-slate-700 bg-white rounded-lg shadow-sm hover:bg-slate-50">Log in</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="px-5 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg shadow-sm hover:bg-blue-700">Registrar</a>
                            @endif
                        @endauth
                    @endif
                </div>
            </nav>
        </header>

        <!-- Conteúdo Principal -->
        <main>
            <!-- Secção "Hero" (Título principal) -->
            <section class="pt-32 pb-16 md:pt-40 md:pb-20">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                    <h1 class="text-4xl md:text-6xl font-extrabold text-slate-900 tracking-tight">
                        Plataforma de Eventos
                    </h1>
                    <h1 class="text-4xl md:text-6xl font-extrabold text-blue-600 tracking-tight mt-2">
                        Inteligente & Fluida.
                    </h1>
                    <p class="mt-6 max-w-2xl mx-auto text-lg text-slate-600">
                        De acadêmicos a corporativos, nossa plataforma simplifica cada etapa. Crie, gerencie, inscreva-se e participe. Tudo em um só lugar.
                    </p>
                    <div class="mt-8">
                        <a href="#eventos" class="px-8 py-3 text-base font-medium text-white bg-blue-600 rounded-lg shadow-md hover:bg-blue-700 transition-colors duration-200">
                            Ver Eventos Abertos
                        </a>
                    </div>
                </div>
            </section>

            <!-- 
              👇👇 O CARROSSEL DE EVENTOS (Swiper.js) 👇👇
            -->
            <section id="eventos" class="py-12 md:py-20 bg-white">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                    <h2 class="text-3xl font-bold text-slate-900">Eventos com Inscrições Abertas</h2>
                    <p class="mt-2 text-md text-slate-500">Encontre o próximo evento que vai impulsionar sua carreira.</p>
                </div>
                
                <!-- O Container do Swiper -->
                <div class="swiper event-carousel mt-12">
                    <div class="swiper-wrapper">
                        
                        <!-- Loop pelos eventos -->
                        @forelse ($events as $event)
                        <div class="swiper-slide">
                            <!-- Card do Evento -->
                            <a href="{{ route('events.public.show', $event) }}" class="block bg-white rounded-2xl shadow-xl overflow-hidden transition-transform duration-300 ease-in-out hover:scale-[1.02]">
                                <!-- A Imagem (Capa) -->
                                <div class="w-full h-48 md:h-64 bg-slate-200">
                                    @if($event->cover_image_path)
                                        <img src="{{ Storage::url($event->cover_image_path) }}" alt="Capa: {{ $event->title }}" class="w-full h-full object-cover">
                                    @else
                                        <!-- Placeholder se não tiver capa -->
                                        <div class="w-full h-full flex items-center justify-center bg-slate-200">
                                            <span class="text-slate-500">Sem Capa</span>
                                        </div>
                                    @endif
                                </div>
                                
                                <!-- Conteúdo do Card -->
                                <div class="p-5 text-left">
                                    <h3 class="font-bold text-lg text-slate-900 truncate">{{ $event->title }}</h3>
                                    <p class="text-sm text-slate-600 mt-1">{{ \Carbon\Carbon::parse($event->event_date)->format('d \d\e M, Y') }}</p>
                                    <p class="text-sm text-slate-600 truncate">{{ $event->location }}</p>
                                    
                                    <!-- Preço (ou Gratuito) -->
                                    <div class="mt-3">
                                        @if($event->registration_fee > 0)
                                            <span class="text-base font-bold text-blue-600">R$ {{ number_format($event->registration_fee, 2, ',', '.') }}</span>
                                        @else
                                            <span class="text-base font-bold text-green-600">Gratuito</span>
                                        @endif
                                    </div>
                                </div>
                            </a>
                        </div>
                        @empty
                        <div class="swiper-slide">
                            <p class="text-slate-600">Nenhum evento com inscrição aberta no momento.</p>
                        </div>
                        @endforelse

                    </div>
                    
                    <!-- Navegação (Setas) -->
                    <div class="swiper-button-prev text-blue-600 after:text-xl"></div>
                    <div class="swiper-button-next text-blue-600 after:text-xl"></div>
                </div>

            </section>
        </main>
        
        <!-- Footer -->
        <footer class="py-12 bg-slate-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <p class="text-slate-600">&copy; {{ date('Y') }} Fatec Eventos. Todos os direitos reservados.</p>
            </div>
        </footer>

        <!-- Script para INICIAR o Swiper.js -->
        <script>
            var swiper = new Swiper('.event-carousel', {
                // Configurações
                loop: false, // Se for true, fica infinito
                slidesPerView: 'auto', // Mostra slides baseado no CSS (75% ou 50%)
                centeredSlides: true,
                spaceBetween: 24, // Espaço entre os cards
                
                // Navegação (Setas)
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
            });
        </script>

    </body>
</html>