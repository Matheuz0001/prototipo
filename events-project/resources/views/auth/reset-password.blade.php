<x-guest-layout>
    <div class="mb-10 text-center select-none">
        <h1 class="text-3xl font-black text-white tracking-tighter uppercase italic">Nova <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#4f46e5] to-[#9333ea]">Senha</span></h1>
        <p class="text-slate-500 text-xs font-bold uppercase tracking-widest mt-2">Defina seu novo acesso ao sistema</p>
    </div>

    <form method="POST" action="{{ route('password.store') }}" class="space-y-6">
        @csrf

        <!-- Token de Redefinição de Senha -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Endereço de E-mail -->
        <div>
            <x-input-label for="email" :value="__('E-mail')" class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2 ms-4" />
            <x-text-input id="email" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-xs font-bold text-red-500" />
        </div>

        <!-- Senha -->
        <div>
            <x-input-label for="password" :value="__('Senha')" class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2 ms-4" />
            <x-text-input id="password" type="password" name="password" required autocomplete="new-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-xs font-bold text-red-500" />
        </div>

        <!-- Confirmar Senha -->
        <div>
            <x-input-label for="password_confirmation" :value="__('Confirmar Senha')" class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2 ms-4" />
            <x-text-input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-xs font-bold text-red-500" />
        </div>

        <div class="pt-4">
            <x-primary-button class="w-full justify-center py-5">
                {{ __('Redefinir Senha') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
