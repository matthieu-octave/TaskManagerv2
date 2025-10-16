<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class RegistrationTest extends TestCase
{
    use RefreshDatabase; // Réinitialise la base de données avant chaque test     *
    #[Test]
    public function a_new_user_can_register(): void
    {
        // On simule une requête POST vers la route d'inscription
        $response = $this->post('/inscription', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        // 1. On vérifie que l'utilisateur est bien authentifié
        $this->assertAuthenticated();

        // 2. On vérifie qu'il est redirigé vers le tableau de bord
        $response->assertRedirect('/dashboard');

        // 3. On vérifie que l'utilisateur existe dans la base de données
        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com',
        ]);
    }
}
