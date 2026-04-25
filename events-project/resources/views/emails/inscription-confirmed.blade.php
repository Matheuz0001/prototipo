<x-mail::message>
# Inscrição Confirmada

Olá, sua inscrição foi realizada com sucesso em nossa plataforma!

O próximo passo é realizar o pagamento para confirmar sua participação no evento. Acesse seu painel para enviar o comprovante.

<x-mail::button :url="config('app.url') . '/dashboard'">
Acessar Meu Painel
</x-mail::button>

Atenciosamente,<br>
Equipe {{ config('app.name') }}
</x-mail::message>
