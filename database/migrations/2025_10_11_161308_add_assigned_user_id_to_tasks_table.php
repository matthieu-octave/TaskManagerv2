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
        Schema::table('tasks', function (Blueprint $table) {
            $table->foreignId('assigned_user_id')
                ->nullable() // La tâche peut ne pas être assignée
                ->constrained('users') // Fait référence à la table 'users'
                ->onDelete('set null'); // Si l'utilisateur est supprimé, la tâche n'est plus assignée
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            //
        });
    }
};
