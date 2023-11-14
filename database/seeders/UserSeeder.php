<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        DB::table('user')->insert([
            'name' => 'Jeferson Padilha',
            'email' => 'jeferson_death@yahoo.com.br',
            'password' => Hash::make('samuca06'),
            'user_verified' => true
        ]);

        DB::table('user')->insert([
            'name' => 'Jefferson Santos',
            'email' => 'jeffersonsantos@gmail.com.br',
            'password' => Hash::make('12345678'),
            'user_verified' => true
        ]);
    }
}
