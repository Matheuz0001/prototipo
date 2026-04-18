<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\EventStaff;

class EnsureStaffEventContext
{
    public function handle(Request $request, Closure $next): Response
    {
        $event = $request->route('event');
        $eventId = is_object($event) ? $event->id : $event;

        if (!$eventId) {
            abort(403, 'Contexto de evento ausente.');
        }

        $user = $request->user();

        if (!$user) {
            abort(401, 'Não autenticado.');
        }

        $isStaff = EventStaff::where('event_id', $eventId)
            ->where('user_id', $user->id)
            ->where('is_active', true)
            ->exists();

        if (!$isStaff) {
            abort(403, 'Acesso Negado: Você não é Colaborador deste evento.');
        }

        return $next($request);
    }
}
