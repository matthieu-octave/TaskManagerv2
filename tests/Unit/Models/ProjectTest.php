<?php

namespace Tests\Unit\Models;

use PHPUnit\Framework\TestCase;
use App\Models\Project;
use App\Models\User;
use Database\Factories\ProjectFactory;
use Database\Factories\UserFactory;


class ProjectTest extends TestCase
{
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
