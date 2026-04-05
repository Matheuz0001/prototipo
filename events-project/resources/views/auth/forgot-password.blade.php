<x-guest-layout>
    <div class="mb-10 text-center select-none">
        <h1 class="text-3xl font-black text-white tracking-tighter uppercase italic">Recuperar <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#4f46e5] to-[#9333ea]">Senha</span></h1>
        <p class="text-slate-500 text-xs font-bold uppercase tracking-widest mt-2">Enviaremos um link de redefinição para você</p>
    </div>

    <div class="mb-6 text-sm text-gray-400 ms-4">
        {{ __('Esqueceu sua senha? Sem problemas. Basta nos informar seu endereço de e-mail e enviaremos um link de redefinição de senha para que você possa escolher uma nova.') }}
    </div>

    <!-- Status da Sessão -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
        @csrf

        <!-- Endereço de E-mail -->
        <div>
            <x-input-label for="email" :value="__('E-mail')" class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2 ms-4" />
            <x-text-input id="email" type="email" name="email" :value="old('email')" required autofocus placeholder="seu@email.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-xs font-bold text-red-500" />
        </div>

        <div class="pt-4">
            <x-primary-button class="w-full justify-center py-5">
                {{ __('Enviar link de redefinição') }}
            </x-primary-button>
        </div>

        <div class="text-center pt-8 border-t border-white/5 mt-8">
            <a href="{{ route('login') }}" class="text-xs font-bold text-slate-500 uppercase tracking-widest hover:text-white transition-colors">
                Voltar para o Login
            </a>
        </div>
    </form>
</x-guest-layout>
