<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
        {{ __('Bem-vindo ao PÁTIO Staff. Clique no botão abaixo para confirmar seu acesso ao sistema de credenciamento do evento.') }}
    </div>

    <form method="POST" action="{{ route('staff.magic_login.confirm', $token) }}">
        @csrf

        <div class="flex items-center justify-end mt-4">
            <x-primary-button class="ms-3 bg-indigo-600 hover:bg-indigo-500 text-white font-bold py-2 px-4 rounded-xl">
                {{ __('Acessar Scanner') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
