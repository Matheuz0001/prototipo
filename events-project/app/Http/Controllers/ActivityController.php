<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActivityController extends Controller
{
    /**
     * Mostra o formulário para criar uma nova atividade para um evento.
     */
    public function create(Event $event)
    {
        // Segurança: O usuário logado é o dono do evento?
        if (Auth::id() !== $event->user_id) {
            abort(403, 'Acesso não autorizado.');
        }

        return view('activities.create', [
            'event' => $event
        ]);
    }

    /**
     * Salva a nova atividade no banco.
     */
    public function store(Request $request, Event $event)
    {
        // Segurança
        if (Auth::id() !== $event->user_id) {
            abort(403, 'Acesso não autorizado.');
        }

        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'max_participants' => 'nullable|integer|min:1',
        ]);

        // Adiciona o event_id aos dados validados
        $validatedData['event_id'] = $event->id;

        Activity::create($validatedData);

        // Redireciona de volta para a PÁGINA DE EDIÇÃO DO EVENTO
        return redirect()->route('events.edit', $event)->with('success', 'Atividade adicionada com sucesso!');
    }

    /**
     * Mostra o formulário para editar uma atividade.
     */
    public function edit(Activity $activity)
    {
        // Carrega a informação do evento pai
        $activity->load('event');

        // Segurança: O usuário é dono do evento pai?
        if (Auth::id() !== $activity->event->user_id) {
            abort(403, 'Acesso não autorizado.');
        }

        return view('activities.edit', [
            'activity' => $activity
        ]);
    }

    /**
     * Salva a atualização da atividade.
     */
    public function update(Request $request, Activity $activity)
    {
        $activity->load('event');
        // Segurança
        if (Auth::id() !== $activity->event->user_id) {
            abort(403, 'Acesso não autorizado.');
        }

        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'max_participants' => 'nullable|integer|min:1',
        ]);

        $activity->update($validatedData);

        // Redireciona de volta para a PÁGINA DE EDIÇÃO DO EVENTO
        return redirect()->route('events.edit', $activity->event_id)->with('success', 'Atividade atualizada com sucesso!');
    }

    /**
     * Exclui a atividade.
     */
    public function destroy(Activity $activity)
    {
        $activity->load('event');
        // Segurança
        if (Auth::id() !== $activity->event->user_id) {
            abort(403, 'Acesso não autorizado.');
        }

        // Salva o ID do evento pai ANTES de deletar
        $eventId = $activity->event_id;

        $activity->delete();

        // Redireciona de volta para a PÁGINA DE EDIÇÃO DO EVENTO
        return redirect()->route('events.edit', $eventId)->with('success', 'Atividade excluída com sucesso!');
    }
}