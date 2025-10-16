<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tag;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Tag::create(['name' => 'Urgent']);
        Tag::create(['name' => 'Marketing']);
        Tag::create(['name' => 'Développement']);
        Tag::create(['name' => 'Design']);
        Tag::create(['name' => 'Stratégie']);
    }
}
