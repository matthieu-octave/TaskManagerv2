<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Supprime l'utilisateur s'il existe déjà pour éviter les doublons
        User::where('email', 'admin@taskmanager.test')->delete();

        // Crée votre utilisateur principal
        User::create([
            'name' => 'Admin',
            'email' => 'admin@taskmanager.test',
            'password' => Hash::make('password'),
        ]);
    }
}
