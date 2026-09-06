<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register_login_and_logout(): void
    {
        $response = $this->postJson('/api/v1/auth/register', [
            'name' => 'Test Player', 'email' => 'player@example.com', 'password' => 'password123',
        ]);
        $response->assertCreated()->assertJsonPath('data.role', 'player');
        $token = $response->json('token');

        $this->withHeader('Authorization', 'Bearer '.$token)->getJson('/api/v1/auth/me')->assertOk();
        $this->withHeader('Authorization', 'Bearer '.$token)->postJson('/api/v1/auth/logout')->assertOk();
    }
}