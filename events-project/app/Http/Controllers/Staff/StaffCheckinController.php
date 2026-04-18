<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Inscription;
use App\Models\Attendance;
use Illuminate\Support\Facades\Auth;

class StaffCheckinController extends Controller
{
    public function store(Request $request, Event $event)
    {
        $request->validate([
            'code' => 'required|string',
        ]);

        $code = $request->input('code');

        $inscription = Inscription::where('id', $code)->where('event_id', $event->id)->first();

        if (!$inscription) {
            return response()->json([
                'success' => false,
                'message' => 'Inscrição não encontrada para este evento.'
            ], 404);
        }

        $existing = Attendance::where('inscription_id', $inscription->id)->first();

        if ($existing) {
            return response()->json([
                'success' => false,
                'message' => 'O participante já realizou o Check-in.',
                'status' => 'already_used'
            ], 422); 
        }

        Attendance::create([
            'inscription_id' => $inscription->id,
            'event_id' => $event->id,
            'checked_in_by' => Auth::id(),
            'status' => 'approved',
        ]);
        
        $inscription->update(['is_presented' => true]);

        return response()->json([
            'success' => true,
            'message' => 'Check-in autorizado com sucesso!',
            'status' => 'approved'
        ]);
    }
}
