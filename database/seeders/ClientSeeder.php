<?php

namespace Database\Seeders;

use App\Models\Client; // <-- N'oubliez pas d'importer le modèle
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Utilise la ClientFactory pour créer 15 clients
        Client::factory()->count(15)->create();
    }
}
