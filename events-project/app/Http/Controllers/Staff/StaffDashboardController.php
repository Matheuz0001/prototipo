<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Attendance;

class StaffDashboardController extends Controller
{
    public function show(Event $event)
    {
        $inscriptions = $event->inscriptions()
            ->with('user', 'inscriptionType')
            ->get();

        $attendedIds = Attendance::where('event_id', $event->id)
            ->pluck('inscription_id')
            ->toArray();

        $validated = $inscriptions->filter(fn ($i) => in_array($i->id, $attendedIds))->values();
        $pending   = $inscriptions->filter(fn ($i) => !in_array($i->id, $attendedIds))->values();

        return view('staff.dashboard', [
            'event'     => $event,
            'validated' => $validated,
            'pending'   => $pending,
        ]);
    }
}
