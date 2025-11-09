// php artisan make:controller OrganizerWorkController
<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Work;
use Illuminate\Http\Request;

class OrganizerWorkController extends Controller
{
    public function index(Event $event)
    {
        // Verificar se o usuário é organizador do evento
        if ($event->user_id !== auth()->id()) {
            abort(403);
        }

        $works = Work::with(['user', 'workType'])
            ->where('event_id', $event->id)
            ->get();

        return view('organizer.works.index', compact('event', 'works'));
    }

    public function show(Event $event, Work $work)
    {
        if ($event->user_id !== auth()->id()) {
            abort(403);
        }

        return view('organizer.works.show', compact('event', 'work'));
    }
}