<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\WorkType; // Importe o Model

class WorkTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tipos de trabalho comuns em eventos acadêmicos
        WorkType::create(['type' => 'Resumo Simples']);
        WorkType::create(['type' => 'Resumo Expandido']);
        WorkType::create(['type' => 'Artigo Completo']);
        $this->call(UserTypeSeeder::class);
        $this->call(PaymentTypeSeeder::class);
        $this->call(WorkTypeSeeder::class); // 👈 ADICIONE ESTA LINHA
    }
}
