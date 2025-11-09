<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UserType; // 1. Importar o Model

class UserTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 2. Inserir os tipos de usuário
        UserType::create(['type' => 'Participante']);
        UserType::create(['type' => 'Organizador']);
        UserType::create(['type' => 'Avaliador']);
    }
}