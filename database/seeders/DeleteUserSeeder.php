<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DeleteUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Encontre e delete usuários específicos, por exemplo, por email
        User::where('email', 'jeferson_death@yahoo.com.br')->delete();
        User::where('email', 'jeffersonsantos@gmail.com.br')->delete();
        User::where('email', 'klisgabriel@gmail.com')->delete();
        // Adicione mais condições conforme necessário
    }
}
