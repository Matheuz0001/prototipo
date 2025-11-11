<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Work;
use App\Models\WorkType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage; // 👈 ADICIONADO (Necessário para o download)

class WorkController extends Controller
{
    /**
     * Mostra o formulário de submissão de trabalho. (RF-F5)
     */
    public function create(Event $event)
    {
        // 1. Encontrar a inscrição do utilizador logado para este evento
        $inscription = Auth::user()->inscriptions()
            ->where('event_id', $event->id)
            ->first();

        // 2. Verificações de segurança
        if (!$inscription) {
            return redirect()->route('dashboard')->with('error', 'Inscrição não encontrada.');
        }
        if (!$inscription->inscriptionType->allow_work_submission) {
            return redirect()->route('dashboard')->with('error', 'O seu tipo de inscrição não permite submissão de trabalhos.');
        }
        if ($inscription->work_id) {
            return redirect()->route('dashboard')->with('error', 'Você já submeteu um trabalho para esta inscrição.');
        }

        // 3. Buscar os tipos de trabalho (ex: Artigo, Resumo) para o dropdown
        $workTypes = WorkType::all(); 

        return view('works.create', [
            'event' => $event,
            'inscription' => $inscription,
            'workTypes' => $workTypes,
        ]);
    }

    /**
     * Armazena o trabalho submetido. (RF-F5)
     */
    public function store(Request $request, Event $event)
    {
        // 1. Validar os dados do formulário
        $request->validate([
            'title' => 'required|string|max:255',
            'work_type_id' => 'required|exists:work_types,id',
            'advisor' => 'required|string|max:255',
            'co_authors_text' => 'nullable|string|max:255',
            'abstract' => 'required|string|min:100', // Resumo
            'file' => 'required|file|mimes:pdf,doc,docx|max:5120', // 5MB Max
        ]);

        // 2. Encontrar a inscrição (verificação de segurança)
        $inscription = Auth::user()->inscriptions()
            ->where('event_id', $event->id)
            ->firstOrFail();
        
        if ($inscription->work_id) {
            return redirect()->route('dashboard')->with('error', 'Trabalho já submetido.');
        }

        // 3. Armazenar o ficheiro
        $filePath = $request->file('file')->store('works/' . $event->id, 'public');

        // 4. Usar uma Transação para garantir que tudo é salvo
        try {
            DB::beginTransaction();

            // 4a. Criar o registo do Trabalho
            $work = Work::create([
                'user_id' => Auth::id(),
                'work_type_id' => $request->work_type_id,
                'title' => $request->title,
                'abstract' => $request->abstract,
                'advisor' => $request->advisor,
                'co_authors_text' => $request->co_authors_text,
                'file_path' => $filePath,
            ]);

            // 4b. Ligar o Trabalho à Inscrição
            $inscription->work_id = $work->id;
            $inscription->save();

            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();
            // Apagar o ficheiro que foi salvo, já que a BD falhou
            Storage::disk('public')->delete($filePath);
            return back()->with('error', 'Erro ao submeter o trabalho. Tente novamente.');
        }

        // 5. Redirecionar
        return redirect()->route('dashboard')->with('success', 'Trabalho submetido com sucesso!');
    }


     
    public function download(Work $work)
    {
        $user = Auth::user();

        // Lógica de Segurança
        $isAuthor = $user->id === $work->user_id;
        $isOrganizer = $user->id === $work->inscription->event->user_id;
        $isReviewer = $work->reviews()->where('user_id', $user->id)->exists();

        if (!$isAuthor && !$isOrganizer && !$isReviewer) {
            abort(403, 'Acesso não autorizado para baixar este ficheiro.');
        }

        // Verifica se o ficheiro existe no disco
        if (!Storage::disk('public')->exists($work->file_path)) {
            return back()->with('error', 'Ficheiro não encontrado. Pode ter sido removido.');
        }
        
        // Força o download no navegador
        return Storage::disk('public')->download($work->file_path, $work->title . '.pdf'); // (Podemos melhorar o nome do ficheiro)
    }
}