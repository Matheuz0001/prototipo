<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage; // 👈 ADICIONADO

class EventController extends Controller
{
    /**
     * Mostra os eventos do organizador.
     */
    public function index()
    {
        $events = Event::where('user_id', Auth::id())
                       ->orderBy('event_date', 'desc')
                       ->get();
        
        return view('events.index', [
            'events' => $events
        ]);
    }

    /**
     * Mostra o formulário de criação.
     */
    public function create()
    {
        return view('events.create');
    }

    /**
     * Mostra a lista de inscritos do evento (RF_S4 / RF_S1).
     */
    public function show(Event $event)
    {
        if ($event->user_id !== Auth::id()) {
            abort(403);
        }

        $inscriptions = $event->inscriptions()
            ->with(['user', 'inscriptionType', 'payment'])
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('organization.inscriptions.index', compact('event', 'inscriptions'));
    }

    /**
     * Armazena um novo evento. (MÉTODO ATUALIZADO)
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'event_date' => 'required|date',
            'registration_deadline' => 'required|date|after_or_equal:now',
            'max_participants' => 'nullable|integer|min:1',
            'pix_key' => 'required|string|max:255',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        // Adiciona o ID do Organizador
        $validatedData['user_id'] = Auth::id();

        if ($request->hasFile('cover_image')) {
            $path = $request->file('cover_image')->store('event-covers', 'public');
            $validatedData['cover_image_path'] = $path;
        }

        // Cria o Evento
        $event = Event::create($validatedData);

        // Salva os Tipos de Inscrição
        if ($request->has('inscriptions')) {
            foreach ($request->inscriptions as $ins) {
                if (!empty($ins['type'])) {
                    $event->inscriptionTypes()->create([
                        'type' => $ins['type'],
                        'price' => $ins['price'] ?? 0,
                        'allow_work_submission' => isset($ins['allow_work_submission']) ? 1 : 0,
                    ]);
                }
            }
        }

        // Salva a Grade de Atividades
        if ($request->has('activities')) {
            foreach ($request->activities as $act) {
                if (!empty($act['title'])) {
                    $event->activities()->create([
                        'title' => $act['title'],
                        'start_time' => $act['date'] . ' ' . ($act['start_time'] ?? '00:00'),
                        'end_time' => $act['date'] . ' ' . ($act['end_time'] ?? '00:00'),
                        'location' => $act['location'] ?? $event->location,
                        'description' => $act['description'] ?? null,
                        'max_participants' => $act['max_participants'] ?? null,
                    ]);
                }
            }
        }

        return redirect()->route('events.index')->with('success', 'Evento completo criado com sucesso!');
    }

    /**
     * Mostra o formulário de edição.
     */
    public function edit(Event $event)
    {
        if ($event->user_id !== Auth::id()) {
            abort(403);
        }
        return view('events.edit', ['event' => $event]);
    }

    /**
     * Atualiza um evento. (MÉTODO ATUALIZADO)
     */
    public function update(Request $request, Event $event)
    {
        if ($event->user_id !== Auth::id()) {
            abort(403);
        }

        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'event_date' => 'required|date',
            'registration_deadline' => 'required|date',
            'max_participants' => 'nullable|integer|min:1',
            'pix_key' => 'required|string|max:255',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        // 👈 LÓGICA DE UPLOAD/ATUALIZAÇÃO ADICIONADA 👇
        if ($request->hasFile('cover_image')) {
            // Apaga a imagem antiga, se existir
            if ($event->cover_image_path) {
                Storage::disk('public')->delete($event->cover_image_path);
            }
            // Salva a nova imagem
            $path = $request->file('cover_image')->store('event-covers', 'public');
            $validatedData['cover_image_path'] = $path;
        }

        $event->update($validatedData);

        return redirect()->route('events.index')->with('success', 'Evento atualizado com sucesso!');
    }

    /**
     * Remove um evento. (MÉTODO ATUALIZADO)
     */
    public function destroy(Event $event)
    {
        if ($event->user_id !== Auth::id()) {
            abort(403);
        }

        // 👈 APAGAR A IMAGEM JUNTAMENTE COM O EVENTO 👇
        if ($event->cover_image_path) {
            Storage::disk('public')->delete($event->cover_image_path);
        }

        $event->delete();
        
        return redirect()->route('events.index')->with('success', 'Evento excluído com sucesso!');
    }
}