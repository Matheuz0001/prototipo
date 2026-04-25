<x-mail::message>
# Resultado da Avaliação

Olá, seu trabalho acadêmico foi avaliado pelo comitê científico.

Acesse seu painel para conferir o parecer detalhado e os comentários do avaliador.

<x-mail::button :url="config('app.url') . '/dashboard'">
Ver Resultado
</x-mail::button>

Atenciosamente,<br>
Equipe {{ config('app.name') }}
</x-mail::message>
