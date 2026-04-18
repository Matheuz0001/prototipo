<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\User;
use App\Models\MagicLink;
use App\Models\EventStaff;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class StaffAuthController extends Controller
{
    public function generate(Request $request, Event $event)
    {
        $request->validate(['email' => 'required|email']);
        $email = $request->input('email');

        $user = User::firstOrCreate(
            ['email' => $email],
            [
                'name' => explode('@', $email)[0],
                'password' => Hash::make(Str::random(24)),
                'user_type_id' => 3
            ]
        );

        EventStaff::updateOrCreate(
            ['event_id' => $event->id, 'user_id' => $user->id],
            ['is_active' => true]
        );

        MagicLink::where('user_id', $user->id)->whereNull('used_at')->update(['used_at' => now()]);

        $token = hash('sha256', Str::random(64));

        $link = MagicLink::create([
            'user_id' => $user->id,
            'event_id' => $event->id,
            'token' => $token,
            'expires_at' => now()->addHours(4)
        ]);

        return response()->json([
            'success' => true,
            'url' => route('staff.magic_login', $token)
        ]);
    }

    public function login($token)
    {
        $magicLink = MagicLink::where('token', $token)->first();

        // 1. Token inexistente
        if (!$magicLink) {
            abort(401, 'Link de acesso inválido ou inexistente.');
        }

        // 2. Link Expirado (> 4h)
        if ($magicLink->expires_at < now()) {
            abort(403, 'Acesso Negado: O tempo de 4h deste convite expirou. Solicite ao Coordenador um link novo.');
        }

        // Autentica e redireciona (o link pode ser reutilizado dentro da janela de 4h)
        Auth::loginUsingId($magicLink->user_id);
        session(['staff_event_id' => $magicLink->event_id]);

        return redirect()->route('staff.dashboard', $magicLink->event_id);
    }
}
