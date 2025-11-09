<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth; // Importe o Auth

class CheckIsOrganizer
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Verifica se o usuário está logado
        // 2. Verifica se o user_type_id é '1' (Organizador, como definimos no Seeder)
        if (Auth::check() && Auth::user()->user_type_id == 1) {
            // Se for, deixe a requisição continuar
            return $next($request);
        }

        // Se não for, redireciona para o 'dashboard' com um erro
        return redirect('/dashboard')->with('error', 'Acesso não autorizado.');
    }
}