<?php

namespace Database\Seeders;

use App\Models\Notificacao;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NotificacaoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Notificacao::factory()->count(10)->create();
    }
}
