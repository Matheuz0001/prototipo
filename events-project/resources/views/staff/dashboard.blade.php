<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Staff — {{ $event->title }} | PÁTIO</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600,700,800,900&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>

    <style>
        body { font-family: 'Figtree', sans-serif; }
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            20% { transform: translateX(-6px); }
            40% { transform: translateX(6px); }
            60% { transform: translateX(-4px); }
            80% { transform: translateX(4px); }
        }
        .animate-shake { animation: shake 0.35s ease-in-out; }
        @keyframes scan-line {
            0% { top: 10%; }
            50% { top: 85%; }
            100% { top: 10%; }
        }
        .scan-line { animation: scan-line 2.5s ease-in-out infinite; }
        #reader { border: none !important; }
        #reader video { border-radius: 1rem; object-fit: cover; }
        #reader__scan_region { border-radius: 1rem; overflow: hidden; }
        #reader__dashboard { display: none !important; }
    </style>
</head>
<body class="bg-[#121214] text-white min-h-screen antialiased overflow-x-hidden">

    {{-- Ambient Spotlight --}}
    <div id="ambientSpotlight" class="fixed top-[-100px] left-1/2 -translate-x-1/2 w-[500px] h-[350px] rounded-full blur-[130px] pointer-events-none z-0 bg-indigo-500/15 transition-all duration-700"></div>

    <div class="relative z-10 min-h-screen flex flex-col" id="appShell">

        {{-- ══════════════════════════════════════════ --}}
        {{-- HEADER --}}
        {{-- ══════════════════════════════════════════ --}}
        <header class="w-full px-5 pt-6 pb-5 border-b border-white/5">
            <div class="max-w-2xl mx-auto flex items-center justify-between">
                <div class="min-w-0">
                    <p class="text-[10px] font-black tracking-[0.25em] uppercase text-indigo-400 mb-1">PÁTIO · Staff</p>
                    <h1 class="text-lg font-black text-white truncate leading-tight uppercase italic tracking-tighter">{{ $event->title }}</h1>
                </div>
                <div class="flex items-center gap-2 shrink-0 ml-4 bg-emerald-500/10 border border-emerald-500/20 rounded-full px-3 py-1.5">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                    </span>
                    <span class="text-[10px] font-bold text-emerald-400 uppercase tracking-wider">Online</span>
                </div>
            </div>
        </header>

        {{-- ══════════════════════════════════════════ --}}
        {{-- CONTEÚDO --}}
        {{-- ══════════════════════════════════════════ --}}
        <main class="flex-grow flex flex-col items-center px-4 sm:px-5 py-6 max-w-2xl mx-auto w-full gap-5">

            {{-- ─── TABS ─────────────────────────── --}}
            <div class="w-full flex bg-[#0a0a0a] border border-white/5 rounded-2xl p-1 gap-1">
                <button id="tabScanner" onclick="switchTab('scanner')" class="flex-1 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all bg-indigo-600 text-white">
                    Scanner
                </button>
                <button id="tabList" onclick="switchTab('list')" class="flex-1 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all text-slate-500 hover:text-white">
                    Participantes
                </button>
            </div>

            {{-- ═══════════════════════════════════════ --}}
            {{-- PAINEL: SCANNER --}}
            {{-- ═══════════════════════════════════════ --}}
            <div id="panelScanner" class="w-full flex flex-col gap-5">

                {{-- Card Scanner --}}
                <div class="w-full bg-[#0a0a0a] backdrop-blur-xl border border-white/5 rounded-2xl shadow-2xl p-5 sm:p-6 relative overflow-hidden" id="mainCard">
                    <div class="absolute top-0 left-0 right-0 h-[3px] bg-gradient-to-r from-indigo-500 via-purple-500 to-emerald-500"></div>

                    {{-- Feedback Overlay --}}
                    <div id="feedbackBox" class="hidden absolute inset-0 z-40 flex items-center justify-center rounded-2xl transition-all duration-300">
                        <div class="text-center px-8 py-10">
                            <div id="feedbackIcon" class="mx-auto mb-4 w-16 h-16 rounded-full flex items-center justify-center"></div>
                            <h3 id="feedbackTitle" class="text-2xl font-black uppercase tracking-wider mb-2"></h3>
                            <p id="feedbackMessage" class="text-sm font-semibold opacity-80"></p>
                        </div>
                    </div>

                    <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest text-center mb-5">Terminal de Check-in</p>

                    {{-- Scanner Area --}}
                    <div id="reader-container" class="hidden w-full aspect-square rounded-2xl overflow-hidden border-2 border-white/10 bg-black relative mb-5">
                        <div id="reader" class="w-full h-full"></div>
                        <div class="absolute inset-0 pointer-events-none z-10">
                            <div class="absolute top-3 left-3 w-8 h-8 border-t-2 border-l-2 border-indigo-400 rounded-tl-lg"></div>
                            <div class="absolute top-3 right-3 w-8 h-8 border-t-2 border-r-2 border-indigo-400 rounded-tr-lg"></div>
                            <div class="absolute bottom-3 left-3 w-8 h-8 border-b-2 border-l-2 border-indigo-400 rounded-bl-lg"></div>
                            <div class="absolute bottom-3 right-3 w-8 h-8 border-b-2 border-r-2 border-indigo-400 rounded-br-lg"></div>
                            <div class="scan-line absolute left-[8%] w-[84%] h-[2px] bg-indigo-500 shadow-[0_0_12px_#6366f1,0_0_30px_#6366f1]"></div>
                        </div>
                    </div>

                    {{-- CTA: Iniciar Scanner --}}
                    <button id="startScannerBtn" class="w-full py-5 rounded-2xl bg-gradient-to-r from-[#4f46e5] to-[#9333ea] text-white font-black text-sm uppercase tracking-widest shadow-xl shadow-indigo-500/20 hover:shadow-[0_0_30px_rgba(79,70,229,0.4)] hover:scale-[1.02] active:scale-95 transition-all flex items-center justify-center">
                        Iniciar Scanner
                    </button>

                    {{-- Parar Scanner --}}
                    <button id="stopScannerBtn" class="hidden w-full py-3.5 rounded-2xl bg-red-500/10 border border-red-500/30 text-red-400 font-black text-[10px] uppercase tracking-widest hover:bg-red-500/20 transition-all mt-3">
                        Parar Scanner
                    </button>
                </div>

                {{-- Busca Manual --}}
                <div class="w-full bg-[#0a0a0a] backdrop-blur-lg border border-white/5 rounded-2xl p-5">
                    <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-3 flex items-center gap-2">
                        <svg class="w-3.5 h-3.5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        Busca Manual
                    </p>
                    <form id="manualCheckinForm" class="flex gap-3">
                        <input type="text" id="manualCodeInput" class="flex-grow bg-[#121214] border border-white/10 rounded-xl px-4 py-3 text-white placeholder-slate-600 text-sm font-mono tracking-wider focus:outline-none focus:ring-2 focus:ring-indigo-500/40 transition-all" placeholder="ID do ingresso...">
                        <button type="submit" class="bg-gradient-to-r from-[#4f46e5] to-[#9333ea] hover:shadow-indigo-500/30 text-white rounded-xl px-5 py-3 font-black text-[10px] uppercase tracking-widest transition-all shadow-lg shadow-indigo-600/20 active:scale-95 shrink-0">
                            Validar
                        </button>
                    </form>
                </div>
            </div>

            {{-- ═══════════════════════════════════════ --}}
            {{-- PAINEL: LISTA DE PARTICIPANTES --}}
            {{-- ═══════════════════════════════════════ --}}
            <div id="panelList" class="w-full hidden flex flex-col gap-5">

                {{-- Contadores --}}
                <div class="grid grid-cols-3 gap-3">
                    <div class="bg-[#0a0a0a] border border-white/5 rounded-2xl p-4 text-center">
                        <p class="text-2xl font-black text-white">{{ $validated->count() + $pending->count() }}</p>
                        <p class="text-[9px] font-black text-slate-500 uppercase tracking-widest mt-1">Inscritos</p>
                    </div>
                    <div class="bg-emerald-500/5 border border-emerald-500/20 rounded-2xl p-4 text-center">
                        <p class="text-2xl font-black text-emerald-400">{{ $validated->count() }}</p>
                        <p class="text-[9px] font-bold text-emerald-500/70 uppercase tracking-widest mt-1">Validados</p>
                    </div>
                    <div class="bg-amber-500/5 border border-amber-500/20 rounded-2xl p-4 text-center">
                        <p class="text-2xl font-black text-amber-400">{{ $pending->count() }}</p>
                        <p class="text-[9px] font-bold text-amber-500/70 uppercase tracking-widest mt-1">Pendentes</p>
                    </div>
                </div>

                {{-- Filtro --}}
                <div class="flex bg-[#0a0a0a] border border-white/5 rounded-2xl p-1 gap-1">
                    <button onclick="filterList('all')" id="filterAll" class="flex-1 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all bg-white/10 text-white">Todos</button>
                    <button onclick="filterList('validated')" id="filterValidated" class="flex-1 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all text-slate-500 hover:text-white">Validados</button>
                    <button onclick="filterList('pending')" id="filterPending" class="flex-1 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all text-slate-500 hover:text-white">Pendentes</button>
                </div>

                {{-- Lista --}}
                <div class="w-full space-y-2" id="participantsList">

                    @forelse($validated as $inscription)
                    <div class="participant-row" data-status="validated">
                        <div class="flex items-center justify-between p-4 bg-[#0a0a0a] border border-white/5 rounded-2xl hover:border-emerald-500/20 transition-all">
                            <div class="flex items-center gap-3 min-w-0">
                                <div class="w-9 h-9 rounded-full bg-emerald-500/20 flex items-center justify-center shrink-0">
                                    <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                </div>
                                <div class="min-w-0">
                                    <p class="text-sm font-bold text-white truncate">{{ $inscription->user->name }}</p>
                                    <p class="text-[10px] text-slate-500 truncate">{{ $inscription->inscriptionType->type ?? 'N/A' }} · #{{ $inscription->id }}</p>
                                </div>
                            </div>
                            <span class="text-[9px] font-bold text-emerald-400 uppercase tracking-wider bg-emerald-500/10 px-2.5 py-1 rounded-full shrink-0 ml-2">Validado</span>
                        </div>
                    </div>
                    @empty
                    @endforelse

                    @forelse($pending as $inscription)
                    <div class="participant-row" data-status="pending">
                        <div class="flex items-center justify-between p-4 bg-[#0a0a0a] border border-white/5 rounded-2xl hover:border-amber-500/20 transition-all">
                            <div class="flex items-center gap-3 min-w-0">
                                <div class="w-9 h-9 rounded-full bg-amber-500/10 flex items-center justify-center shrink-0">
                                    <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </div>
                                <div class="min-w-0">
                                    <p class="text-sm font-bold text-white truncate">{{ $inscription->user->name }}</p>
                                    <p class="text-[10px] text-slate-500 truncate">{{ $inscription->inscriptionType->type ?? 'N/A' }} · #{{ $inscription->id }}</p>
                                </div>
                            </div>
                            <span class="text-[9px] font-bold text-amber-400 uppercase tracking-wider bg-amber-500/10 px-2.5 py-1 rounded-full shrink-0 ml-2">Pendente</span>
                        </div>
                    </div>
                    @empty
                    @endforelse

                    @if($validated->isEmpty() && $pending->isEmpty())
                    <div class="text-center py-12 border-2 border-dashed border-white/10 rounded-2xl">
                        <p class="text-sm text-slate-500 font-black uppercase tracking-widest italic">Nenhum participante inscrito neste evento.</p>
                    </div>
                    @endif
                </div>
            </div>

        </main>

        {{-- FOOTER --}}
        <footer class="w-full py-4 text-center border-t border-white/5">
            <p class="text-[10px] text-slate-600 font-black uppercase tracking-widest">PÁTIO © {{ date('Y') }}</p>
        </footer>
    </div>

    {{-- ═══════════════════════════════════════════ --}}
    {{-- JAVASCRIPT --}}
    {{-- ═══════════════════════════════════════════ --}}
    <script>
        const EVENT_ID = '{{ $event->id }}';
        const CHECKIN_URL = `/staff/events/${EVENT_ID}/checkin`;
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

        // ─── TAB SWITCHING ───────────────────────
        function switchTab(tab) {
            const panelScanner = document.getElementById('panelScanner');
            const panelList    = document.getElementById('panelList');
            const tabScanner   = document.getElementById('tabScanner');
            const tabList      = document.getElementById('tabList');

            if (tab === 'scanner') {
                panelScanner.classList.remove('hidden');
                panelList.classList.add('hidden');
                tabScanner.classList.add('bg-indigo-600', 'text-white');
                tabScanner.classList.remove('text-gray-400');
                tabList.classList.remove('bg-indigo-600', 'text-white');
                tabList.classList.add('text-gray-400');
            } else {
                panelScanner.classList.add('hidden');
                panelList.classList.remove('hidden');
                tabList.classList.add('bg-indigo-600', 'text-white');
                tabList.classList.remove('text-gray-400');
                tabScanner.classList.remove('bg-indigo-600', 'text-white');
                tabScanner.classList.add('text-gray-400');
            }
        }

        // ─── LIST FILTER ─────────────────────────
        function filterList(filter) {
            const rows = document.querySelectorAll('.participant-row');
            const btns = { all: document.getElementById('filterAll'), validated: document.getElementById('filterValidated'), pending: document.getElementById('filterPending') };

            Object.values(btns).forEach(b => { b.classList.remove('bg-white/10', 'text-white'); b.classList.add('text-gray-400'); });
            btns[filter].classList.add('bg-white/10', 'text-white');
            btns[filter].classList.remove('text-gray-400');

            rows.forEach(row => {
                if (filter === 'all') { row.style.display = ''; }
                else { row.style.display = row.dataset.status === filter ? '' : 'none'; }
            });
        }

        // ─── DOM REFS ────────────────────────────
        const startScannerBtn  = document.getElementById('startScannerBtn');
        const stopScannerBtn   = document.getElementById('stopScannerBtn');
        const readerContainer  = document.getElementById('reader-container');
        const feedbackBox      = document.getElementById('feedbackBox');
        const feedbackIcon     = document.getElementById('feedbackIcon');
        const feedbackTitle    = document.getElementById('feedbackTitle');
        const feedbackMessage  = document.getElementById('feedbackMessage');
        const ambientSpotlight = document.getElementById('ambientSpotlight');
        const mainCard         = document.getElementById('mainCard');
        const manualForm       = document.getElementById('manualCheckinForm');

        let html5QrcodeScanner = null;
        let isProcessing = false;

        // ─── CHECK-IN ────────────────────────────
        async function processCheckin(code) {
            if (isProcessing) return;
            isProcessing = true;
            if (html5QrcodeScanner) { try { await html5QrcodeScanner.pause(); } catch(e) {} }

            try {
                const res = await fetch(CHECKIN_URL, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
                    body: JSON.stringify({ code: code })
                });
                const data = await res.json();
                if (data.success) { showFeedback('Aprovado', data.message, 'success'); }
                else { showFeedback(data.status === 'already_used' ? 'Já Utilizado' : 'Negado', data.message, 'error'); }
            } catch (err) {
                showFeedback('Erro', 'Sem conexão com o servidor.', 'error');
            }

            setTimeout(async () => {
                resetFeedback();
                if (html5QrcodeScanner) { try { await html5QrcodeScanner.resume(); } catch(e) {} }
                isProcessing = false;
            }, 3000);
        }

        // ─── FEEDBACK ────────────────────────────
        function showFeedback(title, message, type) {
            feedbackBox.classList.remove('hidden');
            feedbackBox.className = 'absolute inset-0 z-40 flex items-center justify-center rounded-2xl transition-all duration-300';

            if (type === 'success') {
                feedbackBox.classList.add('bg-emerald-900/95');
                feedbackIcon.innerHTML = '<svg class="w-8 h-8 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>';
                feedbackIcon.className = 'mx-auto mb-4 w-16 h-16 rounded-full flex items-center justify-center bg-emerald-500/20 border-2 border-emerald-500/40';
                feedbackTitle.className = 'text-2xl font-black uppercase tracking-wider mb-2 text-emerald-400';
                feedbackMessage.className = 'text-sm font-semibold text-emerald-300/80';
                ambientSpotlight.className = 'fixed top-[-100px] left-1/2 -translate-x-1/2 w-[500px] h-[350px] rounded-full blur-[130px] pointer-events-none z-0 bg-emerald-500/25 transition-all duration-700';
                if (navigator.vibrate) navigator.vibrate([100, 50, 100]);
            } else {
                feedbackBox.classList.add('bg-red-900/95');
                feedbackIcon.innerHTML = '<svg class="w-8 h-8 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>';
                feedbackIcon.className = 'mx-auto mb-4 w-16 h-16 rounded-full flex items-center justify-center bg-red-500/20 border-2 border-red-500/40';
                feedbackTitle.className = 'text-2xl font-black uppercase tracking-wider mb-2 text-red-400';
                feedbackMessage.className = 'text-sm font-semibold text-red-300/80';
                ambientSpotlight.className = 'fixed top-[-100px] left-1/2 -translate-x-1/2 w-[500px] h-[350px] rounded-full blur-[130px] pointer-events-none z-0 bg-red-500/30 transition-all duration-700';
                mainCard.classList.add('animate-shake');
                if (navigator.vibrate) navigator.vibrate([300, 100, 300]);
            }
            feedbackTitle.innerText = title;
            feedbackMessage.innerText = message;
        }

        function resetFeedback() {
            feedbackBox.classList.add('hidden');
            mainCard.classList.remove('animate-shake');
            ambientSpotlight.className = 'fixed top-[-100px] left-1/2 -translate-x-1/2 w-[500px] h-[350px] rounded-full blur-[130px] pointer-events-none z-0 bg-indigo-500/15 transition-all duration-700';
        }

        // ─── SCANNER ─────────────────────────────
        startScannerBtn.addEventListener('click', () => {
            startScannerBtn.classList.add('hidden');
            stopScannerBtn.classList.remove('hidden');
            readerContainer.classList.remove('hidden');

            html5QrcodeScanner = new Html5Qrcode("reader");
            html5QrcodeScanner.start(
                { facingMode: "environment" },
                { fps: 30 },
                (decodedText) => processCheckin(decodedText),
                () => {}
            ).catch(() => {
                alert("Permita o acesso à câmera nas configurações do navegador.");
                startScannerBtn.classList.remove('hidden');
                stopScannerBtn.classList.add('hidden');
                readerContainer.classList.add('hidden');
            });
        });

        stopScannerBtn.addEventListener('click', async () => {
            if (html5QrcodeScanner) { try { await html5QrcodeScanner.stop(); } catch(e) {} html5QrcodeScanner = null; }
            
            // Fix iOS/Safari: Hard kill nos tracks da câmera WebRTC
            const videoElem = document.querySelector('#reader video');
            if (videoElem && videoElem.srcObject) {
                videoElem.srcObject.getTracks().forEach(track => track.stop());
                videoElem.srcObject = null;
            }

            readerContainer.classList.add('hidden');
            stopScannerBtn.classList.add('hidden');
            startScannerBtn.classList.remove('hidden');
        });

        // ─── MANUAL ──────────────────────────────
        manualForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const input = document.getElementById('manualCodeInput');
            if (input.value.trim()) { processCheckin(input.value.trim()); input.value = ''; }
        });
    </script>
</body>
</html>
