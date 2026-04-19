<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="overflow-x-hidden max-w-[100vw]">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <title>{{ config('app.name', 'Sistema de Eventos') }}</title>
        <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,800,900&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            html { scroll-behavior: smooth; }
            :root {
                --bg-black: #121214;
                --brand-primary: #4f46e5;
                --brand-secondary: #9333ea;
                --off-white: #f0eee9;
            }
            body { background-color: var(--bg-black); color: var(--off-white); }
            .nav-blur { background-color: rgba(18, 18, 20, 0.5); backdrop-filter: blur(15px); }
            
            @keyframes float {
                0% { transform: translateY(0px) scale(1.05); }
                50% { transform: translateY(-12px) scale(1.07); }
                100% { transform: translateY(0px) scale(1.05); }
            }
            .floating-active {
                animation: float 4s ease-in-out infinite;
            }

            .perspective-container { perspective: 2000px; }
            .bg-transition { transition: background-image 1.2s ease-in-out, opacity 1.2s ease-in-out; }
            .no-select { -webkit-user-select: none; -moz-user-select: none; -ms-user-select: none; user-select: none; -webkit-user-drag: none; }
            .grab-cursor { cursor: grab; }
            .grab-cursor:active { cursor: grabbing; }

            /* Marquee Animation */
            @keyframes marquee {
                0% { transform: translateX(0); }
                100% { transform: translateX(-50%); }
            }
            .animate-marquee {
                animation: marquee 20s linear infinite;
            }
        </style>
    </head>
    <body class="font-sans antialiased bg-[#121214] overflow-x-hidden max-w-[100vw] w-full text-[#f0eee9]" 
          x-data="{ 
            active: 0,
            init() {
                this.active = this.events.length > 0 ? Math.floor(this.events.length / 2) : 0;
            },
            startX: 0,
            isDragging: false,
            events: [
                @foreach($events as $event)
                { 
                    id: {{ $event->id }}, 
                    title: '{{ addslashes($event->title) }}', 
                    date: '{{ \Carbon\Carbon::parse($event->event_date)->format('d/m') }}', 
                    image: '{{ str_starts_with($event->cover_image_path, 'http') ? $event->cover_image_path : asset('storage/' . $event->cover_image_path) }}', 
                    desc: '{{ addslashes(Str::limit($event->description, 120)) }}',
                    url: '{{ route('events.public.show', $event) }}'
                },
                @endforeach
                @if($events->count() == 0)
                { id: 0, title: 'Nenhum evento ativo', date: '--/--', image: '', desc: 'Cadastre eventos no painel.', url: '#' }
                @endif
            ],
            next() { if(this.events.length > 1) this.active = (this.active + 1) % this.events.length },
            prev() { if(this.events.length > 1) this.active = (this.active - 1 + this.events.length) % this.events.length },
            handleStart(e) { this.isDragging = true; this.startX = e.pageX || (e.touches ? e.touches[0].pageX : 0); },
            handleMove(e) {
                if(!this.isDragging) return;
                let currentX = e.pageX || (e.touches ? e.touches[0].pageX : 0);
                let diff = this.startX - currentX;
                if (Math.abs(diff) > 80) { if (diff > 0) this.next(); else this.prev(); this.isDragging = false; }
            },
            getStyle(index) {
                const diff = index - this.active;
                const absDiff = Math.abs(diff);
                const isMobile = window.innerWidth < 768;
                
                // Cálculo de Deslocamento Lateral Percentual (Centralização Garantida)
                // Usamos 60% da largura do card para o gap no Desktop e 45% no Mobile
                let xOffset = diff * (isMobile ? 45 : 60); 
                
                // Profundidade e Rotação 3D
                let zOffset = absDiff * (isMobile ? -150 : -350);
                let rotateY = diff * (isMobile ? -25 : -35);
                
                // Estética e Visibilidade
                let scale = 1 - (absDiff * (isMobile ? 0.15 : 0.1));
                let opacity = 1 - (absDiff * 0.35);
                let zIndex = 100 - absDiff;

                if (absDiff > 2) opacity = 0;

                return `
                    left: 50%;
                    transform: translateX(-50%) translateX(${xOffset}%) translateZ(${zOffset}px) rotateY(${rotateY}deg) scale(${scale});
                    z-index: ${zIndex};
                    opacity: ${opacity};
                    transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
                    pointer-events: ${absDiff === 0 ? 'auto' : 'none'};
                `;
            }
          }"
          @resize.window="active = active"
          @pointerdown="handleStart($event)"
          @pointermove="handleMove($event)"
          @pointerup="isDragging = false"
          @keydown.window.left="prev()"
          @keydown.window.right="next()">

        <div class="fixed inset-0 z-0 pointer-events-none overflow-hidden">
            <template x-for="(event, index) in events" :key="index">
                <div class="absolute inset-0 bg-cover bg-center bg-no-repeat bg-transition grayscale blur-2xl scale-110"
                     :style="'background-image: url(' + event.image + ')'"
                     :class="active === index ? 'opacity-40' : 'opacity-0'">
                </div>
            </template>
            <div class="absolute inset-0 bg-gradient-to-b from-[#121214] via-transparent to-[#121214]"></div>
            <div class="absolute inset-0 bg-[#121214]/70"></div>
        </div>

        <nav class="fixed top-0 w-full nav-blur z-[200] border-b border-white/5 py-4">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-10">
                    <div class="flex-shrink-0 flex items-center">
                        <x-application-logo class="w-auto h-8 object-contain" />
                    </div>
                    <div class="flex items-center gap-6">
                        @auth
                            <div class="flex items-center gap-6">
                                <form method="POST" action="{{ route('logout') }}" class="inline">
                                    @csrf
                                    <button type="submit" class="text-[11px] font-black text-white/70 hover:text-white uppercase tracking-widest transition-colors">SAIR</button>
                                </form>
                                <a href="{{ url('/dashboard') }}" class="px-6 py-3 bg-gradient-to-r from-[#4f46e5] to-[#9333ea] text-white rounded-xl text-[11px] font-black uppercase tracking-widest shadow-[0_0_20px_rgba(79,70,229,0.3)] hover:shadow-[0_0_25px_rgba(79,70,229,0.5)] hover:-translate-y-0.5 transition-all">PAINEL</a>
                            </div>
                        @else
                            <a href="{{ route('login') }}" class="text-[11px] font-black text-white/90 hover:text-white uppercase tracking-widest transition-colors">ENTRAR</a>
                            <a href="{{ route('register') }}" class="px-6 py-2.5 bg-gradient-to-r from-indigo-500 to-purple-500 text-white rounded-xl text-[11px] font-black uppercase tracking-widest shadow-[0_0_20px_rgba(99,102,241,0.3)] hover:shadow-[0_0_30px_rgba(99,102,241,0.5)] hover:-translate-y-0.5 transition-all">CRIAR CONTA</a>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        <!-- HERO E MARQUEE COM PARTÍCULAS COMPARTILHADAS -->
        <div class="relative w-full overflow-hidden z-10">
            <!-- tsParticles Container - Rede Neural -->
            <div id="tsparticles" class="absolute inset-0 w-full h-full -z-10 pointer-events-none"></div>
            
            <!-- Glow Central -->
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[400px] bg-gradient-to-r from-indigo-500/20 to-purple-500/20 rounded-full blur-[120px] pointer-events-none -z-10"></div>
            
            <!-- HERO SECTION REFATORADO: Design Linear / Luma -->
            <section class="relative min-h-[90vh] flex flex-col items-center justify-center pt-32 pb-10 z-10 w-full px-4 sm:px-6 lg:px-8">
                
                <!-- Hero Content -->
                <div class="text-center w-full max-w-5xl mx-auto z-20 relative flex flex-col items-center">
                    <h1 class="text-5xl md:text-7xl lg:text-8xl font-black tracking-tighter text-white leading-[1.05] mb-8 uppercase italic">
                        CONECTANDO MENTES.<br> 
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-purple-500">MOVENDO A CIÊNCIA.</span>
                    </h1>
                    
                    <p class="text-gray-400 max-w-2xl text-lg mb-12">
                        A plataforma unificada para gestão simplificada de eventos, congressos e a submissão de trabalhos científicos.
                    </p>
                    
                    <!-- CTA Button -->
                    <a href="#carrossel" class="px-8 py-4 bg-gradient-to-r from-indigo-500 to-purple-500 text-white font-black rounded-lg uppercase tracking-widest hover:-translate-y-0.5 shadow-[0_0_20px_rgba(99,102,241,0.3)] hover:shadow-[0_0_30px_rgba(99,102,241,0.5)] transition-all duration-300 flex items-center justify-center gap-2 border border-indigo-400/30 w-full sm:w-auto min-w-[240px]">
                        Explorar Eventos
                        <svg class="w-4 h-4 ml-1 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>
                    </a>
                </div>
            </section>

            <!-- FOOTER MARQUEE (Letreiro Animado Infinito Flutuante) -->
            <div class="w-full bg-transparent overflow-hidden py-8 relative z-20 pb-16">
                <!-- Container duplicado para loop contínuo -->
                <div class="flex animate-marquee w-[200%] sm:w-[150%] lg:w-[100%] drop-shadow-[0_10px_20px_rgba(79,70,229,0.1)]">
                    @for ($i = 0; $i < 4; $i++)
                        <div class="flex items-center min-w-max">
                            <span class="text-white text-3xl md:text-5xl font-black italic tracking-tighter uppercase whitespace-nowrap">DESCUBRA</span>
                            <img src="{{ asset('images/favicon.png') }}" class="h-10 md:h-12 w-auto mx-12 inline-block opacity-70" alt="P">
                            <span class="text-white text-3xl md:text-5xl font-black italic tracking-tighter uppercase whitespace-nowrap">SUBMETA</span>
                            <img src="{{ asset('images/favicon.png') }}" class="h-10 md:h-12 w-auto mx-12 inline-block opacity-70" alt="P">
                            <span class="text-white text-3xl md:text-5xl font-black italic tracking-tighter uppercase whitespace-nowrap">CERTIFIQUE-SE</span>
                            <img src="{{ asset('images/favicon.png') }}" class="h-10 md:h-12 w-auto mx-12 inline-block opacity-70" alt="P">
                        </div>
                    @endfor
                </div>
            </div>
        </div>

        <!-- SEÇÃO INDEPENDENTE: Value Cards (Transferidos do Hero) -->
        <section class="w-full relative z-20 py-16 px-4 border-t border-white/5 bg-gradient-to-b from-black/50 to-transparent">
            <div class="w-full max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Card 1 -->
                <div class="bg-white/[0.02] backdrop-blur-md border border-white/5 rounded-2xl p-8 hover:border-indigo-500/30 hover:bg-white/[0.04] transition-all duration-500 group shadow-2xl">
                    <div class="w-12 h-12 rounded-lg bg-indigo-500/10 border border-indigo-500/20 flex items-center justify-center mb-6 group-hover:scale-110 group-hover:bg-indigo-500/20 transition-all duration-500">
                        <svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <h3 class="text-white font-black text-lg uppercase tracking-wider mb-3">Descubra</h3>
                    <p class="text-slate-400 text-sm leading-relaxed font-normal">Encontre simpósios, congressos e palestras na sua área de interesse.</p>
                </div>
                
                <!-- Card 2 -->
                <div class="bg-white/[0.02] backdrop-blur-md border border-white/5 rounded-2xl p-8 hover:border-purple-500/30 hover:bg-white/[0.04] transition-all duration-500 group shadow-2xl relative overflow-hidden">
                    <div class="w-12 h-12 rounded-lg bg-purple-500/10 border border-purple-500/20 flex items-center justify-center mb-6 group-hover:scale-110 group-hover:bg-purple-500/20 transition-all duration-500">
                        <svg class="w-5 h-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <h3 class="text-white font-black text-lg uppercase tracking-wider mb-3">Submeta</h3>
                    <p class="text-slate-400 text-sm leading-relaxed font-normal">Envie seus trabalhos acadêmicos e acompanhe a avaliação em tempo real.</p>
                </div>

                <!-- Card 3 -->
                <div class="bg-white/[0.02] backdrop-blur-md border border-white/5 rounded-2xl p-8 hover:border-pink-500/30 hover:bg-white/[0.04] transition-all duration-500 group shadow-2xl">
                    <div class="w-12 h-12 rounded-lg bg-pink-500/10 border border-pink-500/20 flex items-center justify-center mb-6 group-hover:scale-110 group-hover:bg-pink-500/20 transition-all duration-500">
                        <svg class="w-5 h-5 text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path></svg>
                    </div>
                    <h3 class="text-white font-black text-lg uppercase tracking-wider mb-3">Certifique-se</h3>
                    <p class="text-slate-400 text-sm leading-relaxed font-normal">Gere seus certificados e comprove suas horas complementares em um clique.</p>
                </div>
            </div>
        </section>

        <section id="carrossel" class="relative min-h-screen flex flex-col items-center z-10 w-full max-w-[100vw] overflow-hidden grab-cursor no-select pt-24 md:pt-32">
            <div class="text-center mb-4 md:mb-6 select-none relative z-20">
                <h2 class="text-[10px] font-black text-[#4f46e5] uppercase tracking-[1.5em] mb-2">Destaques</h2>
                <h1 class="text-3xl md:text-5xl lg:text-7xl font-black tracking-tighter uppercase italic text-white leading-none pb-2" x-text="events[active].title"></h1>
            </div>
            <div class="relative w-full max-w-[100vw] h-[400px] md:h-[450px] flex justify-center items-center" style="perspective: 2000px; transform-style: preserve-3d;">
                <div class="absolute w-[800px] h-[400px] bg-gradient-to-r from-[#4f46e5]/20 to-[#9333ea]/20 rounded-full blur-[120px] animate-pulse pointer-events-none"></div>

                <template x-for="(event, index) in events" :key="index">
                    <div class="absolute transition-all duration-1000 select-none no-select" :style="getStyle(index)" style="transform-style: preserve-3d;">
                        <a :href="event.url" draggable="false" class="block w-[280px] h-[380px] md:w-[640px] md:h-[360px] bg-black relative shadow-[0_50px_100px_rgba(0,0,0,0.9)] rounded-2xl overflow-hidden group no-select border border-white/5" :class="active === index ? 'floating-active border-white/20 shadow-[0_0_100px_rgba(79,70,229,0.3)]' : 'cursor-pointer'">
                            <img :src="event.image" draggable="false" class="w-full h-full object-cover pointer-events-none rounded-2xl transition-all duration-700 no-select" :class="active !== index ? 'grayscale opacity-40 scale-110' : 'opacity-100 scale-100'">
                            <div x-show="active !== index" class="absolute inset-0 bg-black/40 transition-opacity duration-1000"></div>
                            <div class="absolute inset-0 bg-gradient-to-t from-black via-black/20 to-transparent p-6 sm:p-12 flex flex-col justify-end" x-show="active === index" x-transition.opacity.duration.800ms>
                                <div class="flex items-center gap-4 mb-2">
                                    <span class="px-3 py-1 bg-gradient-to-r from-[#4f46e5] to-[#9333ea] text-white font-black text-[10px] uppercase tracking-widest shadow-xl rounded-2xl" x-text="event.date"></span>
                                    <span class="text-white font-black text-[10px] uppercase tracking-[0.3em] opacity-50">Exclusivo</span>
                                </div>
                                <h3 class="text-xl sm:text-3xl font-black text-white leading-tight uppercase italic" x-text="event.title"></h3>
                            </div>
                        </a>
                    </div>
                </template>
            </div>
            <div class="max-w-2xl text-center px-6 mt-6 md:mt-20 select-none">
                <p class="text-slate-400 text-base md:text-lg font-medium leading-relaxed mb-6 md:mb-10" x-text="events[active].desc"></p>
                <div class="flex justify-center gap-6">
                    <a :href="events[active].url" class="px-10 py-4 md:px-16 md:py-5 bg-gradient-to-r from-[#4f46e5] to-[#9333ea] text-white font-black rounded-2xl uppercase tracking-widest hover:scale-105 transition-all shadow-[0_20px_50px_rgba(79,72,229,0.3)] text-[10px] md:text-base">
                        Inscrever-se Agora
                    </a>
                </div>
            </div>
            <div class="flex gap-4 mt-16 pb-10">
                <template x-for="(event, index) in events" :key="index">
                    <button @click="active = index" class="h-1.5 transition-all duration-700 rounded-full" :class="active === index ? 'w-16 bg-[#4f46e5]' : 'w-6 bg-white/10'"></button>
                </template>
            </div>
        </section>

        <section id="eventos" class="py-24 z-10 relative border-t border-white/5" 
                 style="background-image: url('/images/background_pro.jpg'); 
                        background-repeat: no-repeat; 
                        background-position: center; 
                        background-size: cover;">
            <div class="absolute inset-0 bg-black/[0.986] z-0"></div>
            <div class="absolute inset-x-0 top-0 h-48 bg-gradient-to-b from-black to-transparent z-0"></div>
            <div class="absolute inset-x-0 bottom-0 h-48 bg-gradient-to-t from-black to-transparent z-0"></div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-10 gap-4 border-b border-white/5 pb-4">
                    <div>
                        <h2 class="text-3xl font-black text-white uppercase italic tracking-tight">
                            Grade <br>
                            <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-purple-600">Completa</span>
                        </h2>
                    </div>
                    <form method="GET" action="{{ route('home') }}" class="relative w-full md:w-1/3">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="h-4 w-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar eventos..." 
                            class="w-full bg-[#121214] border border-white/10 rounded-2xl py-3 pl-10 pr-4 text-white text-[10px] font-black uppercase tracking-widest focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all placeholder-slate-600 shadow-inner">
                    </form>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @forelse ($events as $event)
                        <a href="{{ route('events.public.show', $event) }}" 
                           class="group bg-[#111114] border border-white/5 rounded-2xl overflow-hidden hover:bg-[#1c1c21] transition-all duration-500 flex flex-col sm:flex-row h-full sm:min-h-[240px] relative shadow-2xl">
                            <div class="w-full sm:w-1/3 h-56 sm:h-auto relative overflow-hidden flex-shrink-0 border-b sm:border-b-0 sm:border-r border-white/5">
                                <img src="{{ str_starts_with($event->cover_image_path, 'http') ? $event->cover_image_path : asset('storage/' . $event->cover_image_path) }}" 
                                     class="absolute inset-0 w-full h-full object-cover opacity-80 group-hover:opacity-100 group-hover:scale-110 transition-all duration-1000">
                                <div class="absolute inset-0 bg-gradient-to-r from-transparent to-[#16161a]/40 hidden sm:block"></div>
                                <div class="absolute inset-0 bg-gradient-to-t from-[#16161a] via-transparent to-transparent sm:hidden"></div>
                            </div>

                            <div class="p-8 flex-1 flex flex-col justify-between relative z-10">
                                <div>
                                    <div class="flex items-center justify-between mb-3">
                                        <span class="text-[9px] font-black text-[#4f46e5] uppercase tracking-[0.3em] block">{{ \Carbon\Carbon::parse($event->event_date)->format('d . M . Y') }}</span>
                                        <span class="px-2 py-0.5 bg-indigo-500/10 text-indigo-400 rounded-full text-[8px] font-black uppercase tracking-widest border border-indigo-500/20">Ativo</span>
                                    </div>
                                    <h3 class="text-xl font-black text-[#f0eee9] uppercase italic group-hover:text-white line-clamp-2 leading-tight h-[3rem] overflow-hidden transition-colors">{{ $event->title }}</h3>
                                    <p class="text-slate-500 text-[10px] font-bold uppercase tracking-widest mt-2 opacity-60">{{ Str::limit($event->location, 30) }}</p>
                                </div>
                                <div class="mt-6 flex items-center justify-between border-t border-white/5 pt-4">
                                    <div class="flex flex-col">
                                        <span class="text-[8px] font-black text-slate-500 uppercase tracking-widest">Inscrição</span>
                                        <span class="text-lg font-black uppercase text-white tracking-tighter">R$ {{ number_format($event->registration_fee, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="flex items-center gap-2 group-hover:translate-x-1 transition-transform">
                                        <span class="text-[9px] font-black uppercase tracking-widest text-indigo-400">Ver Detalhes</span>
                                        <svg class="w-4 h-4 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @empty
                        <p class="col-span-full text-center py-24 text-slate-600 font-black uppercase tracking-widest italic">Nenhum evento disponível.</p>
                    @endforelse
                </div>
            </div>
        </section>

        <footer class="bg-black py-32 relative z-[20] border-t border-white/5">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <x-application-logo class="w-auto h-16 mx-auto mb-12 opacity-100 brightness-0 invert relative z-30" />
                <p class="text-[10px] font-black uppercase tracking-[0.5em] mb-4 text-slate-500 relative z-30">
                    Sistema de Gestão de Eventos - FATEC &copy; {{ date('Y') }} Todos os direitos reservados.
                </p>
            </div>
        </footer>

        <!-- tsParticles scripts -->
        <script src="https://cdn.jsdelivr.net/npm/tsparticles@3.0.3/tsparticles.bundle.min.js"></script>
        <script>
            (async () => {
                const particlesContainer = await tsParticles.load({
                    id: "tsparticles",
                    options: {
                        fullScreen: { enable: false, zIndex: 0 },
                        particles: {
                            number: { value: 60, density: { enable: true, width: 800 } },
                            color: { value: ["#4f46e5", "#9333ea"] },
                            shape: { type: "circle" },
                            opacity: { value: 0.5, random: true },
                            size: { value: { min: 1, max: 3 } },
                            links: {
                                enable: true,
                                distance: 140,
                                color: "#6366f1",
                                opacity: 0.15,
                                width: 1
                            },
                            move: {
                                enable: true,
                                speed: 0.5,
                                direction: "none",
                                random: false,
                                straight: false,
                                outModes: { default: "out" }
                            }
                        },
                        interactivity: {
                            detectsOn: "window",
                            events: {
                                onHover: { enable: true, mode: "grab" },
                                onClick: { enable: true, mode: "push" },
                                resize: true
                            },
                            modes: {
                                grab: { distance: 180, links: { opacity: 0.3 } },
                                push: { quantity: 2 }
                            }
                        },
                        detectRetina: true
                    }
                });

                // Optimization: intersection observer pause/play particles 
                const DOMcontainer = document.getElementById('tsparticles');
                if (DOMcontainer && particlesContainer) {
                    const observer = new IntersectionObserver((entries) => {
                        entries.forEach(entry => {
                            if (entry.isIntersecting) {
                                particlesContainer.play();
                            } else {
                                particlesContainer.pause();
                            }
                        });
                    }, { threshold: 0.05 });
                    observer.observe(DOMcontainer);
                }
            })();
        </script>
    </body>
</html>