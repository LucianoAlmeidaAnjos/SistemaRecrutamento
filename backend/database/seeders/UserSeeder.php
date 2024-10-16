<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'id' => 1,
            'nome' => 'Admin User', // Nome do usuário
            'email' => 'admin@example.com', // Email do usuário
            'password' => bcrypt('admin'), // Senha do usuário, criptografada
            'recrutador' => true, // Definindo como recrutador
        ]);
    }
}
