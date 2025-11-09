<?php

namespace App\Http\Controllers;

use App\Models\Work;
use App\Models\Event;
use App\Models\Inscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class WorkController extends Controller
{
    public function create(Event $event)
    {
        // Verificar se o usuário pode submeter trabalho
        $inscription = Inscription::where('user_id', auth()->id())
            ->where('event_id', $event->id)
            ->where('status', 1) // Inscrição confirmada
            ->first();
            
        if (!$inscription) {
            return redirect()->route('dashboard')->with('error', 'Inscrição não confirmada para este evento.');
        }
        
        // Verificar se o tipo de inscrição permite submissão
        if (!$inscription->inscriptionType->allow_work_submission) {
            return redirect()->route('dashboard')->with('error', 'Seu tipo de inscrição não permite submissão de trabalhos.');
        }
        
        return view('works.create', compact('event'));
    }

    public function store(Request $request, Event $event)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'abstract' => 'required|string|min:100',
            'work_file' => 'required|file|mimes:pdf,doc,docx|max:10240', // 10MB
            'advisor' => 'nullable|string|max:255',
            'co_authors' => 'nullable|string|max:500',
            'work_type_id' => 'required|exists:work_types,id'
        ]);

        // Verificar se já existe trabalho submetido
        $existingWork = Work::where('user_id', auth()->id())
            ->where('event_id', $event->id)
            ->first();
            
        if ($existingWork) {
            return redirect()->back()->with('error', 'Você já submeteu um trabalho para este evento.');
        }

        // Upload do arquivo
        if ($request->hasFile('work_file')) {
            $file = $request->file('work_file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('works', $fileName, 'public');
        }

        Work::create([
            'user_id' => auth()->id(),
            'event_id' => $event->id,
            'title' => $request->title,
            'abstract' => $request->abstract,
            'file_path' => $filePath,
            'file_name' => $file->getClientOriginalName(),
            'advisor' => $request->advisor,
            'co_authors' => $request->co_authors,
            'work_type_id' => $request->work_type_id,
            'status' => 'submitted'
        ]);

        return redirect()->route('dashboard')
            ->with('success', 'Trabalho submetido com sucesso! Aguarde a avaliação.');
    }

    public function download(Work $work)
    {
        // Verificar permissões
        if ($work->user_id !== auth()->id() && !auth()->user()->isOrganizer()) {
            abort(403);
        }

        return Storage::disk('public')->download($work->file_path, $work->file_name);
    }
}