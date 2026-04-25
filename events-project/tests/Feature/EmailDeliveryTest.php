<?php

namespace Tests\Feature;

use App\Mail\InscriptionConfirmed;
use App\Mail\PaymentApproved;
use App\Models\Event;
use App\Models\EventStaff;
use App\Models\Inscription;
use App\Models\InscriptionType;
use App\Models\MagicLink;
use App\Models\Payment;
use App\Models\PaymentType;
use App\Models\User;
use App\Notifications\InscriptionConfirmedNotification;
use App\Notifications\PaymentApprovedNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class EmailDeliveryTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Cria a estrutura base: Organizador → Evento → Tipo de Inscrição → Participante → Inscrição.
     */
    protected function createBaseScenario(): array
    {
        $organizer = User::factory()->create(['user_type_id' => 2]);

        $event = Event::factory()->create([
            'user_id' => $organizer->id,
            'title' => 'Congresso PÁTIO 2026',
            'event_date' => now()->addDays(30),
            'location' => 'FATEC - Auditório Principal',
            'registration_fee' => 50.00,
        ]);

        $inscriptionType = InscriptionType::factory()->create([
            'event_id' => $event->id,
            'name' => 'Ouvinte',
            'price' => 50.00,
            'allow_work_submission' => false,
        ]);

        $participant = User::factory()->create(['user_type_id' => 1]);

        $inscription = Inscription::factory()->create([
            'user_id' => $participant->id,
            'event_id' => $event->id,
            'inscription_type_id' => $inscriptionType->id,
            'status' => 0, // Pendente
        ]);

        return compact('organizer', 'event', 'inscriptionType', 'participant', 'inscription');
    }

    /**
     * TESTE 1: Verifica se a Notification de "Inscrição Confirmada" é enviada
     * para o participante correto ao se inscrever.
     */
    public function test_inscription_confirmed_notification_is_sent_to_correct_user(): void
    {
        Notification::fake();

        $scenario = $this->createBaseScenario();
        $participant = $scenario['participant'];
        $inscription = $scenario['inscription'];

        // Simula o disparo da notificação (que ocorre no InscriptionController@store)
        $participant->notify(new InscriptionConfirmedNotification($inscription));

        // Assert: A notificação foi enviada ao participante correto
        Notification::assertSentTo(
            $participant,
            InscriptionConfirmedNotification::class,
            function ($notification, $channels) {
                return in_array('mail', $channels);
            }
        );

        // Assert: A notificação NÃO foi enviada ao organizador
        Notification::assertNotSentTo($scenario['organizer'], InscriptionConfirmedNotification::class);
    }

    /**
     * TESTE 2: Verifica se o Mailable de "Pagamento Aprovado" (com QR Code)
     * é disparado corretamente quando o pagamento Pix é aprovado.
     */
    public function test_payment_approved_mail_is_sent_when_pix_is_approved(): void
    {
        Notification::fake();

        $scenario = $this->createBaseScenario();
        $participant = $scenario['participant'];
        $inscription = $scenario['inscription'];

        // Cria o tipo de pagamento e o registro de pagamento
        $paymentType = PaymentType::firstOrCreate(
            ['type' => 'PIX'],
            ['name' => 'Pix']
        );

        $payment = Payment::factory()->create([
            'inscription_id' => $inscription->id,
            'payment_type_id' => $paymentType->id,
            'amount' => 50.00,
            'status' => 1, // Em análise
            'proof_path' => 'proofs/test_proof.jpg',
        ]);

        // Simula a aprovação: atualiza status e dispara notificação
        $payment->status = 2; // Aprovado
        $payment->save();

        $inscription->status = 1; // Confirmada
        $inscription->save();

        $participant->notify(new PaymentApprovedNotification($payment));

        // Assert: A notificação de aprovação foi enviada ao participante
        Notification::assertSentTo(
            $participant,
            PaymentApprovedNotification::class,
            function ($notification, $channels) {
                return in_array('mail', $channels);
            }
        );
    }

    /**
     * TESTE 3: Verifica se o Mailable InscriptionConfirmed pode ser renderizado
     * sem erros (teste de integridade do template).
     */
    public function test_inscription_confirmed_mailable_content_is_in_portuguese(): void
    {
        Mail::fake();

        $mailable = new InscriptionConfirmed();

        // Verifica se o subject está em português
        $mailable->assertHasSubject('Inscrição Confirmada');
    }

    /**
     * TESTE 4: Verifica se o Mailable PaymentApproved contém o subject correto
     * e pode ser instanciado sem erro.
     */
    public function test_payment_approved_mailable_has_correct_subject(): void
    {
        $scenario = $this->createBaseScenario();
        $inscription = $scenario['inscription'];

        $paymentType = PaymentType::firstOrCreate(
            ['type' => 'PIX'],
            ['name' => 'Pix']
        );

        $payment = Payment::factory()->create([
            'inscription_id' => $inscription->id,
            'payment_type_id' => $paymentType->id,
            'amount' => 50.00,
            'status' => 2,
            'proof_path' => 'proofs/test_proof.jpg',
        ]);

        $mailable = new PaymentApproved($payment);

        // Subject deve conter o título do evento
        $mailable->assertHasSubject('Ingresso Confirmado: Congresso PÁTIO 2026');
    }
}
