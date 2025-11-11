<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Inscription;
use App\Models\Review;
use App\Models\User;
use App\Models\Work;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubmissionController extends Controller
{
    /**
     * Mostra o painel de gerenciamento de trabalhos para o Organizador. (RF-F6)
     */
    public function index()
    {
        // 1. IDs dos eventos que o Organizador logado gerencia
        $eventIds = Auth::user()->events()->pluck('id');

        // 2. IDs dos trabalhos que pertencem a esses eventos
        // (Nós pegamos os 'work_id' da tabela 'inscriptions')
        $workIds = Inscription::whereIn('event_id', $eventIds)
                              ->whereNotNull('work_id')
                              ->pluck('work_id');
        
        // 3. Busca os trabalhos com seus autores e avaliações já carregadas
        $works = Work::whereIn('id', $workIds)
                     ->with('user', 'workType', 'reviews.user') // 'reviews.user' carrega o avaliador
                     ->get();

        // 4. Busca todos os Avaliadores (ID 3)
        $reviewers = User::where('user_type_id', 3)->get();

        return view('submissions.index', [
            'works' => $works,
            'reviewers' => $reviewers,
        ]);
    }

    /**
     * Atribui um trabalho a um avaliador.
     */
    public function assign(Request $request, Work $work)
    {
        // 1. Validação
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $reviewerId = $request->user_id;

        // 2. Segurança: O Avaliador (ID 3) foi selecionado?
        $reviewer = User::find($reviewerId);
        if ($reviewer->user_type_id != 3) {
            return back()->with('error', 'Este usuário não é um Avaliador.');
        }

        // 3. Esta atribuição já existe?
        $existingReview = Review::where('work_id', $work->id)
                                ->where('user_id', $reviewerId)
                                ->exists();

        if ($existingReview) {
            return back()->with('info', 'Este trabalho já foi atribuído a esse avaliador.');
        }

        // 4. Crie a atribuição (Review Pendente)
        // O status 0 (Pendente) é o padrão (definido na migração)
        Review::create([
            'work_id' => $work->id,
            'user_id' => $reviewerId,
        ]);

        return back()->with('success', 'Trabalho atribuído ao avaliador com sucesso!');
    }
}