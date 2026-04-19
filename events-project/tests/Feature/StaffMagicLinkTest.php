<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\MagicLink;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class StaffMagicLinkTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed([\Database\Seeders\UserTypeSeeder::class]);
    }

    /**
     * Teste de Expiração: Garantir que um link acessado após 4 horas retorne erro 403 e não autentique o usuário.
     */
    #[Test]
    public function it_rejects_expired_magic_links_with_403()
    {
        $user = User::factory()->create(['user_type_id' => 3]);
        $event = Event::factory()->create();
        $token = hash('sha256', Str::random(64));

        $magicLink = MagicLink::create([
            'user_id' => $user->id,
            'event_id' => $event->id,
            'token' => $token,
            'expires_at' => now()->subMinutes(5), // Link expirado há 5 minutos
        ]);

        $response = $this->get(route('staff.magic_login', $token));

        $response->assertStatus(403);
        $this->assertGuest();
    }

    /**
     * Teste Single-Use: Garantir que o mesmo token, se acessado duas vezes, libere o acesso na primeira vez e bloqueie na segunda com erro 403.
     */
    #[Test]
    public function it_rejects_magic_link_if_already_used()
    {
        $user = User::factory()->create(['user_type_id' => 3]);
        $event = Event::factory()->create();
        $token = hash('sha256', Str::random(64));

        $magicLink = MagicLink::create([
            'user_id' => $user->id,
            'event_id' => $event->id,
            'token' => $token,
            'expires_at' => now()->addHours(4),
            'used_at' => null
        ]);

        // Primeira utilização: Deve permitir o login
        // TDD: O anti-bot exige um POST para consumir o token e fazer login
        // Porém, testando o consumo do token:
        $response = $this->post(route('staff.magic_login.confirm', $token));
        
        $response->assertRedirect(route('staff.dashboard', $event->id));
        $this->assertAuthenticatedAs($user);

        // Simulando logout
        auth()->logout();

        // Segunda tentativa: Bloqueio 403
        $response2 = $this->post(route('staff.magic_login.confirm', $token));
        $response2->assertStatus(403);
        $this->assertGuest();
    }

    /**
     * Teste Anti-Bot (Two-Step): Validar que a requisição GET inicial não consome o token (used_at continua nulo), e que apenas a requisição POST de confirmação realiza o login.
     */
    #[Test]
    public function initial_get_request_does_not_consume_token_anti_bot()
    {
        $user = User::factory()->create(['user_type_id' => 3]);
        $event = Event::factory()->create();
        $token = hash('sha256', Str::random(64));

        $magicLink = MagicLink::create([
            'user_id' => $user->id,
            'event_id' => $event->id,
            'token' => $token,
            'expires_at' => now()->addHours(4),
            'used_at' => null
        ]);

        // Ação: GET inicial gerado por rastreadores de e-mail / bots
        $responseGet = $this->get(route('staff.magic_login', $token));
        
        // Verifica se a tela de confirmação foi renderizada (Two-Step), sem fazer login
        $responseGet->assertStatus(200);
        $this->assertGuest();
        
        // Assegura que o token NÃO foi consumido
        $this->assertNull($magicLink->fresh()->used_at);

        // Ação: POST (Botão de 'Acessar' na tela clicado pelo humano)
        $responsePost = $this->post(route('staff.magic_login.confirm', $token));
        
        // Sucesso de login
        $responsePost->assertRedirect(route('staff.dashboard', $event->id));
        $this->assertAuthenticatedAs($user);
        
        // Assegura que o token FOI consumido
        $this->assertNotNull($magicLink->fresh()->used_at);
    }
}
