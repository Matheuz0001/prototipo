<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\Inscription;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class QrCodeScannerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed([\Database\Seeders\UserTypeSeeder::class]);
    }

    protected function generateValidToken(Inscription $inscription): string
    {
        $data = $inscription->id . '-' . $inscription->user_id . '-' . $inscription->event_id;
        return hash('sha256', $data . config('app.key'));
    }

    /**
     * Teste de Sucesso: QR Code válido + Evento correto = Retorna success: true e marca o status como "Presente".
     */
    #[Test]
    public function valid_qr_code_marks_participant_as_attended_with_success_response()
    {
        $organizer = User::factory()->create(['user_type_id' => 2]);
        $event = Event::factory()->create([
            'user_id' => $organizer->id,
            'event_date' => now()->addDays(2) // Evento válido no futuro
        ]);
        
        $participant = User::factory()->create(['user_type_id' => 1]);
        $inscriptionType = \App\Models\InscriptionType::create([
            'event_id' => $event->id,
            'type' => 'Geral',
            'price' => 100.00
        ]);

        $inscription = Inscription::create([
            'user_id' => $participant->id,
            'event_id' => $event->id,
            'inscription_type_id' => $inscriptionType->id,
            'status' => 1, // Pago / Confirmado
            'attended' => false
        ]);

        $token = $this->generateValidToken($inscription);

        $this->actingAs($organizer);

        // Ação: Enviando requisição AJAX do App Mobile Scanner
        $response = $this->postJson(route('attendance.confirm', [
            'inscription' => $inscription->id, 
            'token' => $token
        ]));

        $response->assertStatus(200)
                 ->assertJson([
                     'success' => true,
                     'participant' => $participant->name,
                 ]);

        // Valida no BD se marcou presença
        $this->assertTrue((bool)$inscription->fresh()->attended);
    }

    /**
     * Teste de Duplicidade: Tentar dar check-in em um QR Code que já foi validado.
     */
    #[Test]
    public function duplicate_qr_code_scan_returns_already_used_error()
    {
        $organizer = User::factory()->create(['user_type_id' => 2]);
        $event = Event::factory()->create([
            'user_id' => $organizer->id,
            'event_date' => now()->addDays(2)
        ]);
        
        $participant = User::factory()->create(['user_type_id' => 1]);
        $inscriptionType = \App\Models\InscriptionType::create([
            'event_id' => $event->id,
            'type' => 'Geral',
            'price' => 100.00
        ]);

        $inscription = Inscription::create([
            'user_id' => $participant->id,
            'event_id' => $event->id,
            'inscription_type_id' => $inscriptionType->id,
            'status' => 1,
            'attended' => true // Já deu check-in anteriormente
        ]);

        $token = $this->generateValidToken($inscription);

        $this->actingAs($organizer);

        $response = $this->postJson(route('attendance.confirm', [
            'inscription' => $inscription->id, 
            'token' => $token
        ]));

        // Valida se retornou erro 400 informando duplicidade
        $response->assertStatus(400)
                 ->assertJson([
                     'success' => false,
                 ]);
                 
        $this->assertStringContainsString('já confirmada', $response->json('message'));
    }

    /**
     * Teste de Falsificação: Enviar um código aleatório (99999) e garantir que a API retorna erro sem quebrar a aplicação.
     */
    #[Test]
    public function forged_or_random_qr_code_token_fails_gracefully()
    {
        $organizer = User::factory()->create(['user_type_id' => 2]);
        $event = Event::factory()->create([
            'user_id' => $organizer->id,
            'event_date' => now()->addDays(2)
        ]);
        
        $participant = User::factory()->create(['user_type_id' => 1]);
        $inscriptionType = \App\Models\InscriptionType::create([
            'event_id' => $event->id,
            'type' => 'Geral',
            'price' => 100.00
        ]);

        $inscription = Inscription::create([
            'user_id' => $participant->id,
            'event_id' => $event->id,
            'inscription_type_id' => $inscriptionType->id,
            'status' => 1,
            'attended' => false
        ]);

        $this->actingAs($organizer);

        // Ação: Injetando Token Falso (99999)
        $fakeToken = '99999-forged-token';

        $response = $this->postJson(route('attendance.confirm', [
            'inscription' => $inscription->id, 
            'token' => $fakeToken
        ]));

        // Deve falhar silenciosamente (graceful fail 400 e não 500)
        $response->assertStatus(400)
                 ->assertJson([
                     'success' => false,
                 ]);
                 
        $this->assertStringContainsString('inválido', $response->json('message'));
        
        // Garante que a presença não foi burlada
        $this->assertFalse((bool)$inscription->fresh()->attended);
    }
}
