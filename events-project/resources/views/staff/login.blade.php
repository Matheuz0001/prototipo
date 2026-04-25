<x-guest-layout>
    <div class="mb-10 text-center select-none">
        <div class="w-16 h-16 mx-auto mb-6 rounded-2xl bg-gradient-to-br from-indigo-500/20 to-purple-500/20 border border-indigo-500/30 flex items-center justify-center shadow-lg shadow-indigo-500/10">
            <svg class="w-8 h-8 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
        </div>
        <h1 class="text-3xl font-black text-white tracking-tighter uppercase italic">Confirmar <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#4f46e5] to-[#9333ea]">Acesso</span></h1>
        <p class="text-slate-500 text-xs font-bold uppercase tracking-widest mt-2">Staff — Credenciamento de Evento</p>
    </div>

    <div class="space-y-6">
        {{-- Informações do Magic Link --}}
        <div class="p-5 bg-[#121214] border border-white/5 rounded-2xl space-y-3">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-indigo-500/10 border border-indigo-500/20 flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                </div>
                <div>
                    <span class="text-[9px] font-black text-slate-600 uppercase tracking-widest block">Staff</span>
                    <span class="text-sm font-bold text-white">{{ $magicLink?->user?->name ?? 'Staff' }}</span>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-purple-500/10 border border-purple-500/20 flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
                <div>
                    <span class="text-[9px] font-black text-slate-600 uppercase tracking-widest block">Evento</span>
                    <span class="text-sm font-bold text-white">{{ $magicLink?->event?->title ?? 'Evento' }}</span>
                </div>
            </div>
        </div>

        <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest text-center leading-relaxed px-2">
            Ao confirmar, você será autenticado e redirecionado diretamente para o scanner de credenciamento.
        </p>

        <form method="POST" action="{{ route('staff.magic_login.confirm', $token) }}">
            @csrf
            <button type="submit" class="w-full py-5 bg-gradient-to-r from-[#4f46e5] to-[#9333ea] text-white font-black rounded-2xl uppercase tracking-widest text-[11px] shadow-xl shadow-indigo-500/20 hover:shadow-[0_0_30px_rgba(79,70,229,0.4)] hover:scale-[1.02] hover:-translate-y-0.5 transition-all cursor-pointer flex items-center justify-center gap-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                Confirmar Acesso
            </button>
        </form>
    </div>

    <div class="text-center pt-8 border-t border-white/5 mt-8">
        <p class="text-[9px] font-bold text-slate-600 uppercase tracking-widest">
            Link único • Expira em 4 horas • Uso exclusivo
        </p>
    </div>
</x-guest-layout>
