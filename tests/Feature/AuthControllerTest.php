<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * Test user registration.
     *
     * @return void
     */
    public function test_user_registration()
    {
        // Prepare data for registration
        $data = [
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'password' => 'password123',
            'c_password' => 'password123',
        ];

        $response = $this->postJson('/api/register', $data);

        // Check if registration was successful and token is returned
        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data' => ['token', 'name'],
                'message'
            ]);

        $this->assertDatabaseHas('users', [
            'email' => 'johndoe@example.com',
        ]);
    }


    /**
     * Test user login.
     *
     * @return void
     */
    public function test_user_login()
    {
        // Create a user for login
        $user = User::factory()->create([
            'password' => bcrypt($password = 'password123'),
        ]);

        // Prepare login data
        $data = [
            'email' => $user->email,
            'password' => $password,
        ];

        $response = $this->postJson('/api/login', $data);

        // Check if login was successful and token is returned
        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data' => ['token', 'name', 'role'],
                'message'
            ]);
    }


    /**
     * Test user login with incorrect credentials.
     *
     * @return void
     */
    public function test_user_login_with_invalid_credentials()
    {
        // Send POST request with incorrect login credentials
        $data = [
            'email' => 'nonexistent@example.com',
            'password' => 'wrongpassword',
        ];

        $response = $this->postJson('/api/login', $data);

        // Check if an error response is returned
        $response->assertStatus(403)
            ->assertJson([
                'success' => false,
                'message' => 'Unauthorised.',
                'data' => ['error' => 'Unauthorised']
            ]);
    }

    /**
     * Test user logout.
     *
     * @return void
     */
    public function test_user_logout()
    {
        // Create a user for login
        $user = User::factory()->create([
            'password' => bcrypt($password = 'password123'),
        ]);

        // Simulate the user login and issue a token
        Sanctum::actingAs($user);

        $response = $this->postJson('/api/logout');

        // Check if the logout was successful
        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'User logged out successfully.',
            ]);
    }
}
