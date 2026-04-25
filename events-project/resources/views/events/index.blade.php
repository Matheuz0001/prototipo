<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center mb-2 gap-4">
            <h1 class="text-4xl font-black italic text-white uppercase tracking-wider">
                GESTÃO DE <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-purple-500">EVENTOS</span>
            </h1>
            <div class="flex flex-col sm:flex-row items-center gap-4 w-full md:w-auto">
                <div class="relative w-full max-w-md">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="h-4 w-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <input type="text" id="managerSearchInput" placeholder="Buscar eventos..."
                        class="w-full bg-[#121214] border border-white/10 text-white rounded-xl pl-10 pr-4 py-2 text-[10px] font-black uppercase tracking-widest focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all placeholder-slate-600">
                </div>
                <a href="{{ route('events.create') }}" class="px-6 py-3 bg-gradient-to-r from-[#4f46e5] to-[#9333ea] text-white rounded-2xl font-black text-[10px] uppercase tracking-widest shadow-xl hover:scale-105 transition-all whitespace-nowrap">
                    + Criar Novo Evento
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-[#121214]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="bg-[#0a0a0a] border border-white/5 shadow-2xl rounded-[2.5rem] overflow-hidden">
                <div class="p-6 sm:p-10">
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-white/5">
                            <thead>
                                <tr>
                                    <th class="px-6 py-4 text-left text-[10px] font-black text-slate-500 uppercase tracking-widest">Evento</th>
                                    <th class="px-6 py-4 text-left text-[10px] font-black text-slate-500 uppercase tracking-widest">Data / Local</th>
                                    <th class="px-6 py-4 text-left text-[10px] font-black text-slate-500 uppercase tracking-widest">INSCRIÇÕES</th>
                                    <th class="px-6 py-4 text-center text-[10px] font-black text-slate-500 uppercase tracking-widest">Ações</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-white/5">
                                @forelse ($events as $event)
                                    <tr class="manager-event-row hover:bg-white/5 transition-colors group" data-title="{{ strtolower($event->title) }}">
                                        <td class="px-6 py-6">
                                            <div class="flex items-center gap-4">
                                                @if($event->cover_image_path)
                                                    <img src="{{ asset('storage/' . $event->cover_image_path) }}" class="w-12 h-12 rounded-xl object-cover grayscale group-hover:grayscale-0 transition-all">
                                                @else
                                                    <div class="w-12 h-12 bg-white/5 rounded-xl flex items-center justify-center">
                                                        <x-application-logo class="w-6 h-6 text-white/20" />
                                                    </div>
                                                @endif
                                                <div>
                                                    <div class="text-white font-bold text-base uppercase tracking-wide">{{ $event->title }}</div>
                                                    <div class="text-[10px] font-bold text-indigo-400 mt-1 uppercase tracking-widest">R$ {{ number_format($event->registration_fee, 2, ',', '.') }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-6">
                                            <div class="text-gray-400 text-sm font-medium">{{ \Carbon\Carbon::parse($event->event_date)->format('d/m/Y H:i') }}</div>
                                            <div class="text-gray-400 text-sm font-medium mt-1">{{ $event->location }}</div>
                                        </td>
                                        <td class="px-6 py-6">
                                            <div class="inline-flex items-center px-3 py-1 bg-white/5 border border-white/10 rounded-lg text-xs font-black text-white">
                                                {{ $event->inscriptions()->count() }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-6 text-center">
                                            <div class="flex items-center justify-center gap-2">
                                                <a href="{{ route('events.show', $event) }}" class="p-3 bg-white/5 text-indigo-400 hover:bg-indigo-600 hover:text-white rounded-xl transition-all" title="Ver Inscritos">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                                </a>
                                                <a href="{{ route('events.pix.validation', $event) }}" class="p-3 bg-white/5 text-emerald-400 hover:bg-emerald-600 hover:text-white rounded-xl transition-all" title="Validar Pix">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                </a>
                                                <a href="{{ route('events.edit', $event) }}" class="p-3 bg-white/5 text-slate-400 hover:bg-indigo-600 hover:text-white rounded-xl transition-all" title="Editar">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                                </a>
                                                <a href="{{ route('events.export', $event) }}" class="p-3 bg-white/5 text-emerald-500 hover:bg-emerald-600 hover:text-white rounded-xl transition-all" title="Exportar CSV">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                                </a>
                                                <form method="POST" action="{{ route('events.destroy', $event) }}" onsubmit="return confirm('Excluir evento permanentemente?');">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="p-3 bg-white/5 text-red-500 hover:bg-red-600 hover:text-white rounded-xl transition-all">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-20 text-center text-slate-600 font-black uppercase tracking-[0.3em] italic">Você ainda não possui eventos cadastrados</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
    {{-- Live Search: Filtragem client-side da tabela de eventos --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('managerSearchInput');
            const eventRows = document.querySelectorAll('.manager-event-row');

            if (searchInput) {
                searchInput.addEventListener('input', function (e) {
                    const searchTerm = e.target.value.toLowerCase().trim();

                    eventRows.forEach(row => {
                        const title = row.getAttribute('data-title');
                        if (title.includes(searchTerm)) {
                            row.style.display = '';
                        } else {
                            row.style.display = 'none';
                        }
                    });
                });
            }
        });
    </script>
</x-app-layout>