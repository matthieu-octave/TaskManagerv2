<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('projects', function (Blueprint $table) {
        $table->id(); // Crée une colonne 'id' auto-incrémentée
        $table->string('title'); // Crée une colonne VARCHAR pour le titre
        $table->text('description')->nullable(); // Crée une colonne TEXT, qui peut être nulle
        $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Crée la clé étrangère liée à la table 'users'
        $table->timestamps(); // Crée les colonnes 'created_at' et 'updated_at'
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
