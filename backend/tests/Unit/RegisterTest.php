<?php

namespace Tests\Unit;

use App\Models\User;
use Tests\TestCase;


class RegisterTest extends TestCase
{
    

    public function test_user_can_register_successfully()
    {
        $response = $this->postJson('/api/register', [
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        // Debugging: Dump the response content if the status code is not 201
        if ($response->status() !== 201) {
            dump($response->json());
        }

        $response->assertStatus(201)
                ->assertJsonStructure([
                    'user' => [
                        'id',
                        'name',
                        'email',
                        'created_at',
                        'updated_at',
                    ],
                    'access_token',
                ]);

        $this->assertDatabaseHas('users', [
            'email' => 'john.doe@example.com',
        ]);
    }

    public function test_register_validation_error()
    {
        $response = $this->postJson('/api/register', []);
    
        // Debugging: Dump the response content if the status code is not 422
        if ($response->status() !== 422) {
            dump("Unexpected status code: " . $response->status());
            dump("Response content: ", $response->json());
        }
    
        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['name', 'email', 'password']);
    
        // Additional debugging: Output the validation errors
        dump("Validation errors: ", $response->json('errors'));
    }
    

    public function test_register_with_duplicate_email()
    {
        User::factory()->create([
            'email' => 'duplicate@example.com',
        ]);

        $response = $this->postJson('/api/register', [
            'name' => 'Jane Doe',
            'email' => 'duplicate@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['email']);
    }

    public function test_register_password_confirmation_mismatch()
    {
        $response = $this->postJson('/api/register', [
            'name' => 'Jane Doe',
            'email' => 'jane.doe@example.com',
            'password' => 'password',
            'password_confirmation' => 'different_password',
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['password']);
    }
}
