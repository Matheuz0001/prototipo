<?php

namespace App\Http\Controllers;

use App\Models\Event; // 👈 Importe o Model
use Illuminate\Http\Request;

class PublicEventController extends Controller
{
    /**
     * Mostra a página de detalhes de um evento. (RF-S2)
     */
    public function show(Event $event) // O Laravel encontra o evento pelo ID
    {
        // Carrega o evento e, junto com ele ('with'),
        // carrega os Tipos de Inscrição e as Atividades relacionadas
        $event->load('inscriptionTypes', 'activities');

        // Retorna a view de detalhes
        return view('events.public-show', [
            'event' => $event
        ]);
    }
}