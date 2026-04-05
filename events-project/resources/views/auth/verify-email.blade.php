<x-guest-layout>
    <div class="mb-6 text-sm text-slate-400 leading-relaxed">
        Obrigado por se inscrever! Antes de começar, você poderia verificar seu endereço de e-mail clicando no link que acabamos de enviar para você? Se você não recebeu, teremos o prazer de lhe enviar outro.
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 font-bold text-sm text-emerald-400 p-4 bg-emerald-500/10 border border-emerald-500/20 rounded-xl">
            Um novo link foi enviado para o seu e-mail!
        </div>
    @endif

    <div class="mt-8 flex items-center justify-between">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="px-6 py-3 bg-gradient-to-r from-[#4f46e5] to-[#9333ea] text-white rounded-xl font-black text-[10px] uppercase tracking-widest shadow-lg shadow-indigo-500/20 hover:scale-[1.02] transition-all cursor-pointer">
                Reenviar E-mail de Verificação
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="text-sm font-bold text-slate-500 hover:text-white underline transition-colors cursor-pointer relative z-10">
                Sair
            </button>
        </form>
    </div>
</x-guest-layout>