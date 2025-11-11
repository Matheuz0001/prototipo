<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-900 leading-tight">
            Editar Evento: <span class="text-blue-600">{{ $event->title }}</span>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- 
              Card 1: Detalhes Principais do Evento 
              (Este é o card que nós já tínhamos)
            -->
            <!-- 
              👇 MUDANÇA DE ESTILO "PREMIUM" 👇
              shadow-sm sm:rounded-lg -> shadow-xl sm:rounded-2xl
            -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl">
                <div class="p-6 md:p-8 text-slate-900">
                    <h3 class="text-xl font-semibold mb-6">Detalhes Principais</h3>

                    <form method="POST" action="{{ route('events.update', $event) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Título -->
                        <div>
                            <x-input-label for="title" :value="__('Título do Evento')" />
                            <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title', $event->title)" required autofocus />
                        </div>

                        <!-- Descrição -->
                        <div class="mt-4">
                            <x-input-label for="description" :value="__('Descrição Completa')" />
                            <textarea id="description" name="description" rows="5" class="block mt-1 w-full border-slate-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm">{{ old('description', $event->description) }}</textarea>
                        </div>

                        <!-- Local -->
                        <div class="mt-4">
                            <x-input-label for="location" :value="__('Local (ou link, se for online)')" />
                            <x-text-input id="location" class="block mt-1 w-full" type="text" name="location" :value="old('location', $event->location)" required />
                        </div>

                        <!-- Grade de Datas -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                            <div>
                                <x-input-label for="event_date" :value="__('Data e Hora do Evento')" />
                                <x-text-input id="event_date" class="block mt-1 w-full" type="datetime-local" name="event_date" :value="old('event_date', $event->event_date->format('Y-m-d\TH:i'))" required />
                            </div>
                            <div>
                                <x-input-label for="registration_deadline" :value="__('Prazo Limite de Inscrição')" />
                                <x-text-input id="registration_deadline" class="block mt-1 w-full" type="datetime-local" name="registration_deadline" :value="old('registration_deadline', $event->registration_deadline->format('Y-m-d\TH:i'))" required />
                            </div>
                        </div>
                        
                        <!-- Grade de Valores -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                            <div>
                                <x-input-label for="registration_fee" :value="__('Taxa de Inscrição (R$)')" />
                                <x-text-input id="registration_fee" class="block mt-1 w-full" type="number" name="registration_fee" :value="old('registration_fee', $event->registration_fee)" required step="0.01" min="0" />
                            </div>
                            <div>
                                <x-input-label for="max_participants" :value="__('Máx. de Participantes')" />
                                <x-text-input id="max_participants" class="block mt-1 w-full" type="number" name="max_participants" :value="old('max_participants', $event->max_participants)" min="1" />
                            </div>
                        </div>

                        <!-- Chave Pix -->
                        <div class="mt-4">
                            <x-input-label for="pix_key" :value="__('Chave Pix (para pagamento)')" />
                            <x-text-input id="pix_key" class="block mt-1 w-full" type="text" name="pix_key" :value="old('pix_key', $event->pix_key)" required />
                        </div>

                        <!-- Campo de Edição da Capa -->
                        <div class="mt-6 border-t border-slate-200 pt-6">
                            <h4 class="text-lg font-semibold">Capa do Evento</h4>
                            @if ($event->cover_image_path)
                                <div class="mt-4">
                                    <p class="text-sm font-medium text-slate-700 mb-2">Capa Atual:</p>
                                    <img src="{{ Storage::url($event->cover_image_path) }}" alt="Capa do Evento" class="w-full h-auto max-w-sm rounded-lg object-cover shadow-md">
                                </div>
                            @else
                                <p class="text-sm text-slate-500 mt-2">Este evento ainda não tem uma imagem de capa.</p>
                            @endif
                            <div class="mt-4">
                                <x-input-label for="cover_image" :value="__('Enviar Nova Capa (JPG, PNG, WEBP - Máx 2MB)')" />
                                <p class="text-xs text-slate-500 mb-1">Selecione uma nova imagem apenas se quiser **substituir** a capa atual.</p>
                                <input id="cover_image" name="cover_image" type="file" accept="image/jpeg,image/png,image/jpg,image/webp" class="block w-full text-sm text-slate-500 file:me-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-600 file:text-white file:hover:bg-blue-700 mt-1">
                                <x-input-error :messages="$errors->get('cover_image')" class="mt-2" />
                            </div>
                        </div>
                        
                        <div class="flex items-center justify-end mt-6 pt-6 border-t border-slate-200">
                            <a href="{{ route('events.index') }}" class="text-sm text-slate-600 hover:text-slate-900 rounded-md">
                                {{ __('Cancelar') }}
                            </a>
                            <x-primary-button class="ms-4">
                                {{ __('Atualizar Evento') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div> <!-- Fim do Card 1 -->

            <!-- 
              👇👇 SEÇÃO (CARD 2) QUE ESTAVA FALTANDO 👇👇
              Gerenciar Tipos de Inscrição (RF_B3)
            -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl">
                <div class="p-6 md:p-8 text-slate-900">
                    <h3 class="text-xl font-semibold mb-4">Gerenciar Tipos de Inscrição</h3>
                    
                    <!-- Tabela com Tipos Existentes -->
                    <div class="overflow-x-auto mb-4">
                        <table class="min-w-full divide-y divide-slate-200">
                            <thead class="bg-slate-50">
                                <tr>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-slate-500 uppercase">Tipo</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-slate-500 uppercase">Preço</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-slate-500 uppercase">Ações</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-slate-200">
                                @forelse ($event->inscriptionTypes as $type)
                                <tr>
                                    <td class="px-4 py-3 text-sm font-medium text-slate-900">{{ $type->type }}</td>
                                    <td class="px-4 py-3 text-sm text-slate-600">R$ {{ number_format($type->price, 2, ',', '.') }}</td>
                                    <td class="px-4 py-3 text-sm">
                                        <a href="{{ route('inscription_types.edit', $type) }}" class="text-blue-600 hover:text-blue-900">Editar</a>
                                        <form method="POST" action="{{ route('inscription_types.destroy', $type) }}" class="inline-block ml-2" onsubmit="return confirm('Tem certeza?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">Excluir</button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="px-4 py-3 text-sm text-slate-500 text-center">Nenhum tipo de inscrição cadastrado.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Botão para Adicionar Novo Tipo -->
                    <a href="{{ route('inscription_types.create', $event) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                        + Adicionar Novo Tipo
                    </a>
                </div>
            </div> <!-- Fim do Card 2 -->

            <!-- 
              👇👇 SEÇÃO (CARD 3) QUE ESTAVA FALTANDO 👇👇
              Gerenciar Atividades (RF_F8)
            -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl">
                <div class="p-6 md:p-8 text-slate-900">
                    <h3 class="text-xl font-semibold mb-4">Gerenciar Atividades</h3>
                    
                    <!-- Tabela com Atividades Existentes -->
                    <div class="overflow-x-auto mb-4">
                        <table class="min-w-full divide-y divide-slate-200">
                            <thead class="bg-slate-50">
                                <tr>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-slate-500 uppercase">Atividade</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-slate-500 uppercase">Data/Hora</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-slate-500 uppercase">Ações</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-slate-200">
                                {{-- @forelse ($event->activities as $activity) --}}
                                <!-- O Loop de atividades está comentado pois ainda não o implementamos -->
                                {{-- 
                                <tr>
                                    <td class="px-4 py-3 text-sm font-medium text-slate-900">{{ $activity->title }}</td>
                                    <td class="px-4 py-3 text-sm text-slate-600">{{ $activity->start_time->format('d/m H:i') }}</td>
                                    <td class="px-4 py-3 text-sm">
                                        <a href="{{ route('activities.edit', $activity) }}" class="text-blue-600 hover:text-blue-900">Editar</a>
                                        <form method="POST" action="{{ route('activities.destroy', $activity) }}" class="inline-block ml-2" onsubmit="return confirm('Tem certeza?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">Excluir</button>
                                        </form>
                                    </td>
                                </tr> 
                                --}}
                                {{-- @empty --}}
                                <tr>
                                    <td colspan="3" class="px-4 py-3 text-sm text-slate-500 text-center">Nenhuma atividade cadastrada. (RF_F8 pendente)</td>
                                </tr>
                                {{-- @endforelse --}}
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Botão para Adicionar Nova Atividade -->
                    <a href="{{ route('activities.create', $event) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                        + Adicionar Nova Atividade
                    </a>
                </div>
            </div> <!-- Fim do Card 3 -->


        </div>
    </div>
</x-app-layout>