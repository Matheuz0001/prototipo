<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 👇 ADICIONE ESTA LINHA 👇
        $this->call(UserTypeSeeder::class);
        $this->call(PaymentTypeSeeder::class);

        // Opcional: Vamos criar um usuário 'Organizador' para testes
        User::factory()->create([
            'name' => 'Organizador Teste',
            'email' => 'org@fatec.com',
            'password' => bcrypt('123456'), // Lembre-se da senha!
            'user_type_id' => 1, // ID 1 = Organizador
            'email_verified_at' => now(), // Já vem verificado
        ]);
    }
}