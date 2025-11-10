<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\Event;

// Controllers que já estamos a usar
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\PublicEventController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\InscriptionTypeController;
use App\Http\Controllers\InscriptionController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\WorkController;
use App\Http\Controllers\SubmissionController; // 👈 1. ADICIONE ESTE IMPORT

/*
|--------------------------------------------------------------------------
| Rotas Públicas (para todos)
|--------------------------------------------------------------------------
*/

// Rota principal CORRIGIDA (com a busca de eventos)
Route::get('/', function () {
    $events = Event::where('registration_deadline', '>=', now())
        ->orderBy('event_date', 'asc')
        ->get();

    return view('welcome', [
        'events' => $events
    ]);
});

// Rota da página de detalhes (RF-S2)
Route::get('/eventos/{event}', [PublicEventController::class, 'show'])->name('events.public.show');


/*
|--------------------------------------------------------------------------
| Rotas Autenticadas (Login, Dashboard, Profile)
|--------------------------------------------------------------------------
*/

// Rota 'dashboard' com LÓGICA INTELIGENTE (RF-F7) - VERSÃO CORRIGIDA
Route::get('/dashboard', function () {
    
    $user = Auth::user();

    if ($user->user_type_id == 1) { // 1 = Participante
        
        $inscriptions = $user->inscriptions()
                            ->with('event', 'inscriptionType', 'payment', 'work') // Carregar 'work' aqui
                            ->orderBy('created_at', 'desc')
                            ->get();

        return view('dashboard', [
            'userInscriptions' => $inscriptions
        ]);
    
    } elseif ($user->user_type_id == 2) { // 2 = Organizador
        return view('dashboard'); 

    } elseif ($user->user_type_id == 3) { // 3 = Avaliador
        
        // Busca as 'reviews' (atribuições) deste avaliador
        $reviews = $user->reviews()
                       ->with('work.user') // Carrega o trabalho E o autor do trabalho
                       ->where('status', 0) // Mostra apenas avaliações PENDENTES
                       ->get();

        return view('dashboard', [
            'pendingReviews' => $reviews
        ]);
    }

    // Fallback
    return view('dashboard');

})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Rotas de GESTÃO (Organizador) e AÇÕES (Participante)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])->group(function () {
    
    // ----- Rotas que SÓ o Organizador pode acessar -----
    Route::middleware(['organizer'])->group(function () {
        
        // CRUD de Eventos
        Route::resource('events', EventController::class);

        // CRUD de Atividades (RF-F8)
        Route::get('/events/{event}/activities/create', [ActivityController::class, 'create'])->name('activities.create');
        Route::post('/events/{event}/activities', [ActivityController::class, 'store'])->name('activities.store');
        Route::get('/activities/{activity}/edit', [ActivityController::class, 'edit'])->name('activities.edit');
        Route::put('/activities/{activity}', [ActivityController::class, 'update'])->name('activities.update');
        Route::delete('/activities/{activity}', [ActivityController::class, 'destroy'])->name('activities.destroy');

        // CRUD de Tipos de Inscrição (RF-B3)
        Route::get('/events/{event}/inscription-types/create', [InscriptionTypeController::class, 'create'])->name('inscription_types.create');
        Route::post('/events/{event}/inscription-types', [InscriptionTypeController::class, 'store'])->name('inscription_types.store');
        Route::get('/inscription-types/{inscriptionType}/edit', [InscriptionTypeController::class, 'edit'])->name('inscription_types.edit');
        Route::put('/inscription-types/{inscriptionType}', [InscriptionTypeController::class, 'update'])->name('inscription_types.update');
        Route::delete('/inscription-types/{inscriptionType}', [InscriptionTypeController::class, 'destroy'])->name('inscription_types.destroy');
        
        // ROTAS DE VALIDAÇÃO DE PAGAMENTO (RF-F3)
        Route::get('/organizacao/pagamentos', [PaymentController::class, 'index'])->name('organization.payments.index');
        Route::post('/organizacao/pagamentos/{inscription}/aprovar', [PaymentController::class, 'approve'])->name('organization.payments.approve');
        Route::post('/organizacao/pagamentos/{inscription}/recusar', [PaymentController::class, 'reject'])->name('organization.payments.reject');

        // 👇 2. ADICIONE ESTE BLOCO DE ROTAS 👇
        // Rotas de Gerenciamento de Submissões (RF-F6)
        Route::get('/organizacao/submissoes', [SubmissionController::class, 'index'])->name('submissions.index');
        Route::post('/organizacao/submissoes/{work}/atribuir', [SubmissionController::class, 'assign'])->name('submissions.assign');
    });

    // ----- Rotas do Participante (e outros) -----
    
    // Rotas de Inscrição (RF-F1)
    Route::get('/eventos/{event}/inscrever', [InscriptionController::class, 'create'])->name('inscriptions.create');
    Route::post('/eventos/{event}/inscrever', [InscriptionController::class, 'store'])->name('inscriptions.store');

    // ROTAS DE PAGAMENTO (RF-F2)
    Route::get('/inscricoes/{inscription}/pagar', [PaymentController::class, 'create'])->name('payment.create');
    Route::post('/inscricoes/{inscription}/pagar', [PaymentController::class, 'store'])->name('payment.store');

    // ROTAS DE TRABALHOS (RF-F5)
    Route::get('/events/{event}/works/create', [WorkController::class, 'create'])->name('works.create');
    Route::post('/events/{event}/works', [WorkController::class, 'store'])->name('works.store');
    Route::get('/works/{work}/download', [WorkController::class, 'download'])->name('works.download');
});

require __DIR__.'/auth.php';