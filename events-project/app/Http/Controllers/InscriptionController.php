<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Inscription;
use App\Models\InscriptionType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InscriptionController extends Controller
{
    /**
     * Mostra o formulário para o utilizador escolher o tipo de inscrição.
     * (RF-F1 - Passo 2 da Inscrição)
     */
    public function create(Event $event)
    {
        // 1. Carrega os tipos de inscrição (Ouvinte, Autor) que o Organizador criou
        $inscriptionTypes = $event->inscriptionTypes;

        // 2. Verifica se o utilizador já está inscrito neste evento
        $existingInscription = Inscription::where('user_id', Auth::id())
                                          ->where('event_id', $event->id)
                                          ->first();
        
        if ($existingInscription) {
            // Se já está inscrito, manda-o para o painel com um aviso
            return redirect()->route('dashboard')->with('error', 'Você já está inscrito neste evento.');
        }

        // 3. Mostra o formulário de escolha
        return view('inscriptions.create', [
            'event' => $event,
            'inscriptionTypes' => $inscriptionTypes
        ]);
    }

    /**
     * Armazena a nova inscrição no banco de dados.
     * (RF-F1 - Passo 3 da Inscrição)
     */
    public function store(Request $request, Event $event)
    {
        // 1. Validação
        $request->validate([
            'inscription_type_id' => 'required|integer|exists:inscription_types,id',
        ]);

        // 2. Verifica se o tipo de inscrição escolhido pertence mesmo a este evento
        $type = InscriptionType::find($request->inscription_type_id);
        if ($type->event_id !== $event->id) {
            return back()->with('error', 'Tipo de inscrição inválido.');
        }

        // 3. Verifica se o utilizador já está inscrito (dupla verificação)
        $existingInscription = Inscription::where('user_id', Auth::id())
                                          ->where('event_id', $event->id)
                                          ->first();
        
        if ($existingInscription) {
            return redirect()->route('dashboard')->with('error', 'Você já está inscrito neste evento.');
        }

        // 4. Cria a inscrição
        Inscription::create([
            'user_id' => Auth::id(),
            'event_id' => $event->id,
            'inscription_type_id' => $request->inscription_type_id,
            'status' => 0, // 0 = Pendente (aguardando pagamento)
            'attended' => false,
            'presented_work' => false,
        ]);

        // 5. Redireciona para o painel do participante
        // (Vamos criar esta rota no próximo passo, por agora vai para o dashboard)
        return redirect()->route('dashboard')->with('success', 'Inscrição realizada com sucesso! Aguardando pagamento.');
    }
}