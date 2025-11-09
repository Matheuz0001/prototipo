<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserType; // 👈 1. IMPORTE O UserType
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        // 👇 2. BUSQUE OS TIPOS DE USUÁRIO
        $userTypes = UserType::all(); // Ex: "Organizador", "Participante"...

        // 👇 3. ENVIE OS TIPOS PARA A VIEW
        return view('auth.register', [
            'userTypes' => $userTypes
        ]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // 👇 4. ADICIONE A VALIDAÇÃO DO user_type_id
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'user_type_id' => ['required', 'integer', 'exists:user_types,id'], // Garante que o ID enviado existe
        ]);

        // 👇 5. ADICIONE O user_type_id NO CREATE
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'user_type_id' => $request->user_type_id, // Salva o tipo
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}