<?php

namespace App\Http\Controllers;

// IMPORTS
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Para pegar o ID do organizador

class EventController extends Controller
{
    /**
     * Mostra a lista de eventos do organizador logado.
     */
    public function index()
    {
        // 1. Busca no banco TODOS os eventos ONDE o 'user_id'
        //    seja igual ao ID do usuário logado (Auth::id())
        //    e ordena pelos mais novos.
        $events = Event::where('user_id', Auth::id())
                       ->orderBy('created_at', 'desc')
                       ->get();

        // 2. Retorna a view 'events.index' e passa os eventos para ela
        return view('events.index', [
            'events' => $events
        ]);
    }

    /**
     * Mostra o formulário de criação de evento. (RF_B3)
     */
    public function create()
    {
        // Apenas retorna a view que criamos
        return view('events.create');
    }

    /**
     * Salva o novo evento no banco. (RF_B3)
     */
    public function store(Request $request)
    {
        // 1. Validação (Garante que os dados estão corretos)
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'event_date' => 'required|date',
            'registration_deadline' => 'required|date|after_or_equal:now',
            'registration_fee' => 'required|numeric|min:0',
            'max_participants' => 'nullable|integer|min:1',
            'pix_key' => 'nullable|string|max:255',
        ]);

        // 2. Adiciona o ID do Organizador (o usuário logado)
        $validatedData['user_id'] = Auth::id();

        // 3. Cria o Evento no Banco
        Event::create($validatedData);

        // 4. Redireciona de volta para a lista de eventos (Melhor que o dashboard)
        return redirect()->route('events.index')->with('success', 'Evento criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        // (Não estamos a usar este, pois temos o PublicEventController)
    }

    /**
     * Mostra o formulário para editar um evento. (RF-B3 - Update)
     * ESTA É A FUNÇÃO CORRIGIDA
     */
    public function edit(Event $event)
    {
        // 1. Verificação de segurança: O usuário logado é o dono deste evento?
        if (Auth::id() !== $event->user_id) {
            abort(403, 'Acesso não autorizado.');
        }

        // 2. CORREÇÃO: Carrega os "filhos" do evento
        // Isto busca no banco as atividades e tipos de inscrição
        // que pertencem a este evento.
        $event->load('activities', 'inscriptionTypes');

        // 3. Retorna a view de edição, passando o evento
        // (agora $event contém ->activities e ->inscriptionTypes)
        return view('events.edit', [
            'event' => $event
        ]);
    }

    /**
     * Atualiza o evento no banco de dados. (RF-B3 - Update)
     */
    public function update(Request $request, Event $event)
    {
        // 1. Verificação de segurança
        if (Auth::id() !== $event->user_id) {
            abort(403, 'Acesso não autorizado.');
        }

        // 2. Validação (mesma do store)
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'event_date' => 'required|date',
            'registration_deadline' => 'required|date|after_or_equal:now',
            'registration_fee' => 'required|numeric|min:0',
            'max_participants' => 'nullable|integer|min:1',
            'pix_key' => 'nullable|string|max:255',
        ]);

        // 3. Atualiza o evento
        $event->update($validatedData);

        // 4. Redireciona de volta para a lista (index)
        return redirect()->route('events.index')->with('success', 'Evento atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     * ESTA É A FUNÇÃO CORRIGIDA
     */
    public function destroy(Event $event)
    {
        // 1. Verificação de segurança: O usuário logado é o dono deste evento?
        if (Auth::id() !== $event->user_id) {
            abort(403, 'Acesso não autorizado.');
        }

        // 2. Deleta o evento
        // (As atividades e tipos de inscrição serão deletados
        // automaticamente por causa do 'onDelete('cascade')' nas migrations)
        $event->delete();

        // 3. Redireciona de volta para a lista (index) com sucesso
        return redirect()->route('events.index')->with('success', 'Evento excluído com sucesso!');
    }
}