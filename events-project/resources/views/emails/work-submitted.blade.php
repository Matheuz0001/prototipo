<x-mail::message>
# Trabalho Recebido

Olá, seu trabalho acadêmico foi submetido com sucesso!

Ele será encaminhado ao comitê científico para avaliação. Você será notificado assim que o parecer estiver disponível.

<x-mail::button :url="config('app.url') . '/dashboard'">
Acompanhar Submissão
</x-mail::button>

Atenciosamente,<br>
Equipe {{ config('app.name') }}
</x-mail::message>
