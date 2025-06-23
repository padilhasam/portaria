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
            'nome' => 'Administrador',
            'documento' => '01234567891',
            'nascimento' => '1990-04-17',
            'celular' => '41998909779',
            'user'=>'Admin',
            'email' => 'admin@admin.com.br',
            'password' => Hash::make('admin1234'),
            'status' =>'ativo',
            'user_verified' => true
        ]);

        DB::table('users')->insert([
            'nome' => 'Jeferson Padilha',
            'documento' => '45678912330',
            'nascimento' => '1986-10-24',
            'celular' => '419984305610',
            'user'=>'Padilhajeff',
            'email' => 'jeferson_death@yahoo.com.br',
            'password' => Hash::make('samuca06'),
            'status' =>'ativo',
            'user_verified' => true
        ]);

        DB::table('users')->insert([
            'nome' => 'Jefferson Santos',
            'documento' => '78998765425',
            'nascimento' => '1999-09-09',
            'celular' => '41995202654',
            'user'=>'Santosjeff',
            'email' => 'jeffersonsantos@gmail.com.br',
            'password' => Hash::make('12345678'),
            'status' =>'ativo',
            'user_verified' => true
        ]);

    }
}
