<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UserType; // 👈 Importe o Model

class UserTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Vamos criar nossos 3 tipos de usuário
        UserType::create(['type' => 'Organizador']); // ID será 1
        UserType::create(['type' => 'Participante']); // ID será 2
        UserType::create(['type' => 'Avaliador']);   // ID será 3
    }
}