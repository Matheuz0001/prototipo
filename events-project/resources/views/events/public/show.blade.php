<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- O título da página agora é o nome do evento -->
        <title>{{ $event->title }} - {{ config('app.name', 'Laravel') }}</title>

        <!-- Fonte "Inter" -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

        <!-- TailwindCSS (CDN) -->
        <script src="https://cdn.tailwindcss.com"></script>
        
        <script>
            // Configuração do Tailwind (exatamente a mesma da welcome.blade.php)
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
        
    </head>
    
    <!-- Fundo 'slate-100' (branco-gelo) -->
    <body class="font-sans antialiased bg-slate-100 text-slate-900">
        
        <!-- Header (Exatamente o mesmo da welcome.blade.php) -->
        <header class="fixed top-0 left-0 right-0 z-50">
            <nav class="flex justify-between items-center max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-5 bg-slate-100/80 backdrop-blur-md rounded-b-xl shadow-sm">
                
                <!-- Logo -->
                <a href="/" class="flex items-center space-x-3">
                    <svg class="w-8 h-8 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                    </svg>
                    <span class="text-2xl font-bold text-slate-900">Fatec Eventos</span>
                </a>

                <!-- Botões de Login/Registro -->
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
        <main class="pt-24">
            
            <!-- Secção do Banner do Evento -->
            <section class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- Banner/Capa -->
                <div class="w-full h-64 md:h-96 rounded-2xl shadow-xl overflow-hidden bg-slate-200">
                    @if($event->cover_image_path)
                        <img src="{{ Storage::url($event->cover_image_path) }}" alt="Capa: {{ $event->title }}" class="w-full h-full object-cover">
                    @else
                        <!-- Placeholder se não tiver capa -->
                        <div class="w-full h-full flex items-center justify-center">
                            <span class="text-slate-500 text-xl font-semibold">Evento sem capa</span>
                        </div>
                    @endif
                </div>
            </section>

            <!-- Secção de Detalhes do Evento -->
            <section class="py-12 md:py-16">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    
                    <!-- Layout de 2 Colunas (Detalhes + Card de Inscrição) -->
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 lg:gap-12">
                        
                        <!-- Coluna Esquerda: Detalhes -->
                        <div class="lg:col-span-2">
                            <h1 class="text-4xl font-extrabold text-slate-900 tracking-tight">
                                {{ $event->title }}
                            </h1>
                            
                            <!-- Descrição -->
                            <div class="mt-8 prose prose-slate max-w-none text-slate-600 prose-headings:text-slate-800 prose-strong:text-slate-800">
                                <h3 class="text-xl font-semibold mb-2">Sobre o Evento</h3>
                                <p>{{ $event->description }}</p>
                                
                                <!-- (Aqui podemos adicionar a lista de ATIVIDADES no futuro) -->
                            </div>
                        </div>

                        <!-- Coluna Direita: Card de Inscrição (Ação) -->
                        <div class="lg:col-span-1">
                            <!-- O Card "flutuante" -->
                            <div class="sticky top-28 bg-white p-6 rounded-2xl shadow-xl">
                                
                                <!-- Botão de Inscrição -->
                                <div class="mb-5">
                                    @if($event->registration_deadline >= now())
                                        <a href="{{ route('inscriptions.create', $event) }}" class="block w-full text-center px-6 py-3 text-base font-medium text-white bg-blue-600 rounded-lg shadow-md hover:bg-blue-700 transition-colors duration-200">
                                            Quero me Inscrever!
                                        </a>
                                    @else
                                        <button class="block w-full text-center px-6 py-3 text-base font-medium text-slate-700 bg-slate-200 rounded-lg" disabled>
                                            Inscrições Encerradas
                                        </button>
                                    @endif
                                </div>

                                <!-- Detalhes (Data, Local) -->
                                <div class="space-y-3 border-t border-slate-200 pt-5">
                                    <div class="flex items-start">
                                        <svg class="w-5 h-5 text-blue-600 shrink-0 mt-0.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25M3 18.75A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" /></svg>
                                        <div class="ml-3">
                                            <span class="font-semibold text-slate-800">Data</span>
                                            <p class="text-sm text-slate-600">{{ \Carbon\Carbon::parse($event->event_date)->format('d \d\e M, Y \à\s H:i') }}</H4>
                                        </div>
                                    </div>
                                    <div class="flex items-start">
                                        <svg class="w-5 h-5 text-blue-600 shrink-0 mt-0.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" /></svg>
                                        <div class="ml-3">
                                            <span class="font-semibold text-slate-800">Local</span>
                                            <p class="text-sm text-slate-600">{{ $event->location }}</H4>
                                        </div>
                                    </div>
                                </div>

                                <!-- Tipos de Inscrição -->
                                <div class="border-t border-slate-200 mt-5 pt-5">
                                    <h4 class="font-semibold text-slate-800 mb-3">Tipos de Inscrição</h4>
                                    <ul class="space-y-2">
                                        @forelse($event->inscriptionTypes as $type)
                                            <li class="flex justify-between text-sm">
                                                <span class="text-slate-600">{{ $type->type }}</span>
                                                <span class="font-medium text-slate-800">R$ {{ number_format($type->price, 2, ',', '.') }}</span>
                                            </li>
                                        @empty
                                            <li class="text-sm text-slate-500">Nenhum tipo de inscrição definido.</li>
                                        @endforelse
                                    </ul>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </section>
        </main>
        
        <!-- Footer (Exatamente o mesmo da welcome.blade.php) -->
        <footer class="py-12 bg-slate-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <p class="text-slate-600">&copy; {{ date('Y') }} Fatec Eventos. Todos os direitos reservados.</p>
            </div>
        </footer>

    </body>
</html>