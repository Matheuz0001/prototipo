<?php

namespace App\Http\Controllers;

use App\Models\Inscription;
use App\Models\Work;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the dashboard for authenticated users.
     */
    public function index()
    {
        // Buscar todas as inscrições do usuário logado com os relacionamentos necessários
        $userInscriptions = Inscription::with([
            'event', 
            'inscriptionType', 
            'work' // Relacionamento com trabalho se existir
        ])
        ->where('user_id', auth()->id())
        ->orderBy('created_at', 'desc')
        ->get();

        return view('dashboard', compact('userInscriptions'));
    }
}