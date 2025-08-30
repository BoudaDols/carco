<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthControllerTest extends TestCase
{
    public function test_user_can_register()
    {
        $response = $this->postJson('/api/auth/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123'
        ]);

        $response->assertStatus(201)
                ->assertJson(['message' => 'Utilisateur créé avec succès.']);
        
        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com'
        ]);
    }

    public function test_user_cannot_register_with_invalid_data()
    {
        $response = $this->postJson('/api/auth/register', [
            'name' => '',
            'email' => 'invalid-email',
            'password' => '123'
        ]);

        $response->assertStatus(422)
                ->assertJsonStructure(['errors']);
    }

    public function test_user_can_login()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
            'active' => true
        ]);

        $response = $this->postJson('/api/auth/login', [
            'email' => 'test@example.com',
            'password' => 'password123'
        ]);

        $response->assertStatus(200)
                ->assertJsonStructure(['access_token', 'token_type']);
    }

    public function test_inactive_user_cannot_login()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
            'active' => false
        ]);

        $response = $this->postJson('/api/auth/login', [
            'email' => 'test@example.com',
            'password' => 'password123'
        ]);

        $response->assertStatus(422);
    }

    public function test_user_can_get_profile()
    {
        $user = User::factory()->create(['active' => true]);
        
        $response = $this->actingAs($user, 'sanctum')
                        ->getJson('/api/auth/me');

        $response->assertStatus(200)
                ->assertJsonStructure(['id', 'name', 'email', 'active']);
    }

    public function test_user_can_logout()
    {
        $user = User::factory()->create(['active' => true]);
        $token = $user->createToken('test-token');
        
        $response = $this->actingAs($user, 'sanctum')
                        ->postJson('/api/auth/logout');

        $response->assertStatus(200)
                ->assertJson(['message' => 'Déconnexion réussie.']);
    }
}