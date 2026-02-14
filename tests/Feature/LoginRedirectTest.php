<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginRedirectTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that a successful login redirects to the dashboard (index).
     */
    public function test_successful_login_redirects_to_dashboard(): void
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('/index');
        $this->assertAuthenticatedAs($user);
    }

    /**
     * Test that a login with "intended" URL works correctly.
     */
    public function test_login_redirects_to_intended_url(): void
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        // Attempt to access a protected route
        $response = $this->get('/projects');
        $response->assertRedirect('/login');

        // Login
        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('http://localhost/projects');
        $this->assertAuthenticatedAs($user);
    }
}
