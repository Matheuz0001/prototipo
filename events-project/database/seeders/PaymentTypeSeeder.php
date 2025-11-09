<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PaymentType; // 👈 Importe o Model

class PaymentTypeSeeder extends Seeder
{
    public function run(): void
    {
        // Vamos criar o nosso tipo de pagamento
        PaymentType::create(['type' => 'PIX']); // ID será 1
    }
}