<x-mail::message>
# Pagamento Recusado

Olá, infelizmente seu comprovante de pagamento não pôde ser validado.

**Motivo:** O organizador do evento informou que o comprovante enviado não atende aos requisitos necessários.

Por favor, acesse seu painel e envie um novo comprovante de pagamento para que possamos reavaliar sua inscrição.

<x-mail::button :url="config('app.url') . '/dashboard'">
Enviar Novo Comprovante
</x-mail::button>

Atenciosamente,<br>
Equipe {{ config('app.name') }}
</x-mail::message>
