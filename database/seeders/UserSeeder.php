<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'Jeferson Padilha',
            'email' => 'jeferson_death@yahoo.com.br',
            'password' => Hash::make('samuca06'),
            'user_verified' => true
        ]);

        DB::table('users')->insert([
            'name' => 'Jefferson Santos',
            'email' => 'jeffersonsantos@gmail.com.br',
            'password' => Hash::make('12345678'),
            'user_verified' => true
        ]);

        DB::table('users')->insert([
            'name' => 'Klisman Gabriel',
            'email' => 'klisgabriel@gmail.com',
            'password' => Hash::make('klisman2024'),
            'user_verified' => true
        ]);
    }
}
