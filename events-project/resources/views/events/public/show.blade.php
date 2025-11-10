{{-- Usamos o layout de 'convidado', pois esta página é pública --}}
<x-guest-layout>
    <div class="pt-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <h1 class="text-3xl font-bold mb-4">
                        {{ $event->title }}
                    </h1>

                    <div class="mb-6">
                        <p class="text-lg"><strong>Data:</strong> {{ \Carbon\Carbon::parse($event->event_date)->format('d/m/Y \à\s H:i') }}</p>
                        <p class="text-lg"><strong>Local:</strong> {{ $event->location }}</p>
                        <p class="mt-4">{{ $event->description }}</p>
                    </div>

                    <div class="mb-6">
                        <h3 class="text-xl font-semibold mb-3">Tipos de Inscrição</h3>
                        <ul class="list-disc list-inside">
                            @forelse($event->inscriptionTypes as $type)
                                <li>
                                    {{ $type->type }} - 
                                    <strong>R$ {{ number_format($type->price, 2, ',', '.') }}</strong>
                                </li>
                            @empty
                                <li>Nenhum tipo de inscrição definido para este evento.</li>
                            @endforelse
                        </ul>
                    </div>

                    <div class="mt-8 text-center">
                        @if($event->registration_deadline >= now())
                            {{-- A rota 'inscriptions.create' é a que criamos no web.php --}}
                            <a href="{{ route('inscriptions.create', $event) }}"
                               class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-lg px-8 py-3">
                                Quero me Inscrever!
                            </a>
                        @else
                            <p class="text-lg font-semibold text-red-600">
                                As inscrições para este evento já estão encerradas.
                            </p>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-guest-layout>