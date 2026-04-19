<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\Inscription;
use App\Models\InscriptionType;
use App\Models\Payment;
use App\Models\PaymentType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class PixIsolationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Semeia os dados base de domínio para resolver Foreign Keys
        $this->seed([\Database\Seeders\UserTypeSeeder::class, \Database\Seeders\PaymentTypeSeeder::class, \Database\Seeders\WorkTypeSeeder::class]);
    }

    /**
     * Teste de Isolamento de Evento: Crie um cenário onde um Organizador acessa a rota events/{eventA}/validar-pix. 
     * Tente injetar/buscar um pagamento pertencente ao eventB. O sistema OBRIGATORIAMENTE deve retornar 404 
     * ou lista vazia, garantindo que não haja vazamento de dados financeiros entre eventos.
     */
    #[Test]
    public function organizer_cannot_see_or_validate_payments_from_another_event()
    {
        // Setup: Organizador do Evento A
        $organizerA = User::factory()->create(['user_type_id' => 2]);
        $eventA = Event::factory()->create(['user_id' => $organizerA->id]);
        
        // Setup: Organizador do Evento B
        $organizerB = User::factory()->create(['user_type_id' => 2]);
        $eventB = Event::factory()->create(['user_id' => $organizerB->id]);

        // Usuário pagante no Evento B
        $participantB = User::factory()->create(['user_type_id' => 1]);
        $inscriptionTypeB = InscriptionType::create([
            'event_id' => $eventB->id,
            'type' => 'Geral',
            'price' => 100.00
        ]);
        
        $inscriptionB = Inscription::create([
            'user_id' => $participantB->id,
            'event_id' => $eventB->id,
            'inscription_type_id' => $inscriptionTypeB->id,
            'status' => 0 // Pendente
        ]);

        $paymentB = Payment::create([
            'inscription_id' => $inscriptionB->id,
            'payment_type_id' => 1,
            'amount' => 100.00,
            'status' => 1, // Em análise
            'proof_path' => 'proofs/fake.png'
        ]);

        // Autentica como Organizador do Evento A
        $this->actingAs($organizerA);

        // 1. Tentar ver pagamentos na lista do Evento A -> Deve vir vazia
        $responseList = $this->get(route('events.pix.validation', $eventA->id));
        $responseList->assertStatus(200);
        $responseList->assertDontSee($participantB->name);
        
        // 2. Tentar Aprovar o Pagamento B sendo Organizador A
        $responseApprove = $this->post(route('organization.payments.approve', $inscriptionB->id));
        $responseApprove->assertStatus(403); // Acesso Negado
        
        // Garante que o status do pagamento B continua Em Análise (1)
        $this->assertEquals(1, $paymentB->fresh()->status);
    }
}
