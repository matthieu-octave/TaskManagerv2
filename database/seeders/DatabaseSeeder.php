<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Appelle le seeder que nous venons de créer
        $this->call([
            ClientSeeder::class,
        ]);
    }
}
