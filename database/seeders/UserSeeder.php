<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'nome' => 'Jeferson Padilha',
            'user'=>'Padilhajeff',
            'email' => 'jeferson_death@yahoo.com.br',
            'password' => Hash::make('samuca06'),
            'acesso_tipo' =>'liberado',
            'user_verified' => true
        ]);

        DB::table('users')->insert([
            'nome' => 'Jefferson Santos',
            'user'=>'Santosjeff',
            'email' => 'jeffersonsantos@gmail.com.br',
            'password' => Hash::make('12345678'),
            'acesso_tipo' => 'bloqueado',
            'user_verified' => true
        ]);

        DB::table('users')->insert([
            'nome' => 'Klisman Gabriel',
            'user'=>'Gabrielklisman',
            'email' => 'klisgabriel@gmail.com',
            'password' => Hash::make('klisman2024'),
            'acesso_tipo' => 'liberado',
            'user_verified' => true
        ]);
    }
}
