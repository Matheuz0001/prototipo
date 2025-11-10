<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\InscriptionType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InscriptionTypeController extends Controller
{
    /**
     * Mostra o formulário para criar um novo tipo de inscrição para um evento.
     */
    public function create(Event $event)
    {
        // Verifica se o usuário logado é o dono do evento
        if (Auth::id() !== $event->user_id) {
            abort(403, 'Acesso não autorizado.');
        }

        return view('inscription_types.create', [
            'event' => $event
        ]);
    }

    /**
     * Armazena um novo tipo de inscrição no banco de dados.
     */
    public function store(Request $request, Event $event)
    {
        // Verifica se o usuário logado é o dono do evento
        if (Auth::id() !== $event->user_id) {
            abort(403, 'Acesso não autorizado.');
        }

        $validatedData = $request->validate([
            'type' => 'required|string|max:255',
            'price' => 'required|numeric|min:0', // 👈 LINHA ADICIONADA
            'allow_work_submission' => 'nullable|boolean',
        ]);

        // Adiciona o event_id e trata o checkbox (que não envia '0' se desmarcado)
        $validatedData['event_id'] = $event->id;
        $validatedData['allow_work_submission'] = $request->has('allow_work_submission');

        InscriptionType::create($validatedData);

        // Redireciona de volta para a página de edição do evento
        return redirect()->route('events.edit', $event->id)->with('success', 'Tipo de inscrição criado com sucesso!');
    }

    /**
     * Mostra o formulário para editar um tipo de inscrição.
     */
    public function edit(InscriptionType $inscriptionType)
    {
        // Verifica se o usuário logado é o dono do evento pai
        if (Auth::id() !== $inscriptionType->event->user_id) {
            abort(403, 'Acesso não autorizado.');
        }

        return view('inscription_types.edit', [
            'inscriptionType' => $inscriptionType
        ]);
    }

    /**
     * Atualiza o tipo de inscrição no banco de dados.
     */
    public function update(Request $request, InscriptionType $inscriptionType)
    {
        // Verifica se o usuário logado é o dono do evento pai
        if (Auth::id() !== $inscriptionType->event->user_id) {
            abort(403, 'Acesso não autorizado.');
        }

        $validatedData = $request->validate([
            'type' => 'required|string|max:255',
            'price' => 'required|numeric|min:0', // 👈 LINHA ADICIONADA
            'allow_work_submission' => 'nullable|boolean',
        ]);

        // Trata o checkbox (que não envia '0' se desmarcado)
        $validatedData['allow_work_submission'] = $request->has('allow_work_submission');

        $inscriptionType->update($validatedData);

        // Redireciona de volta para a página de edição do evento pai
        return redirect()->route('events.edit', $inscriptionType->event_id)->with('success', 'Tipo de inscrição atualizado com sucesso!');
    }

    /**
     * Remove o tipo de inscrição do banco de dados.
     */
    public function destroy(InscriptionType $inscriptionType)
    {
        // Verifica se o usuário logado é o dono do evento pai
        if (Auth::id() !== $inscriptionType->event->user_id) {
            abort(403, 'Acesso não autorizado.');
        }

        $eventId = $inscriptionType->event_id; // Salva o ID do evento pai antes de deletar
        $inscriptionType->delete();

        return redirect()->route('events.edit', $eventId)->with('success', 'Tipo de inscrição excluído com sucesso!');
    }
}