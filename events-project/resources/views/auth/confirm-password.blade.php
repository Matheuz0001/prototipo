<x-guest-layout>
    <div class="mb-10 text-center select-none">
        <h1 class="text-3xl font-black text-white tracking-tighter uppercase italic">Confirmar <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#4f46e5] to-[#9333ea]">Acesso</span></h1>
        <p class="text-slate-500 text-xs font-bold uppercase tracking-widest mt-2">Área segura do sistema</p>
    </div>

    <div class="mb-6 text-sm text-gray-400 ms-4">
        {{ __('Esta é uma área segura do aplicativo. Por favor, confirme sua senha antes de continuar.') }}
    </div>

    <form method="POST" action="{{ route('password.confirm') }}" class="space-y-6">
        @csrf

        <!-- Senha -->
        <div>
            <x-input-label for="password" :value="__('Senha')" class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2 ms-4" />
            <x-text-input id="password" type="password" name="password" required autocomplete="current-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-xs font-bold text-red-500" />
        </div>

        <div class="pt-4">
            <x-primary-button class="w-full justify-center py-5">
                {{ __('Confirmar') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
