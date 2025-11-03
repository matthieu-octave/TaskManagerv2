<?php

namespace Tests\Unit\Models;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class ProjectTest extends TestCase
{
    use RefreshDatabase; // Réinitialise la base de données avant chaque test

    #[Test]
    public function a_project_belongs_to_a_user(): void
    {
        // ARRANGE : On prépare nos données de test
        $user = User::factory()->create();
        $project = Project::factory()->create(['user_id' => $user->id]);

        // ACT & ASSERT : On agit et on vérifie
        // 1. On vérifie que la relation 'user' renvoie bien un objet de la classe User
        $this->assertInstanceOf(User::class, $project->user);

        // 2. On vérifie que l'utilisateur retourné est bien le bon
        $this->assertEquals($user->id, $project->user->id);
    }
}
