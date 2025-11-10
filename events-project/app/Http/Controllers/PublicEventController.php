<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class PublicEventController extends Controller
{
    /**
     * Exibe a página de detalhes pública de um evento. (RF-S2)
     */
    public function show(Event $event)
    {
        // O Laravel automaticamente encontra o evento pelo ID na URL
        // Agora, carregamos os 'tipos de inscrição' que pertencem a este evento
        $event->load('inscriptionTypes');

        // Retorna a view e passa o evento (com os tipos) para ela
        return view('events.public.show', [
            'event' => $event
        ]);
    }
}