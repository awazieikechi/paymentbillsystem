<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
//use PHPUnit\Framework\TestCase;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    use RefreshDatabase;

    public function test_user_create()
    {
        $userData = [
            'name' => 'Glory Ihe',
            'email' => 'glory.ihe@example.com',
            'phone' => '080789560560',
            'password' => '2345',
            'balance' => 100.00,
        ];

        $response = $this->postJson('/api/v1/users', $userData);

        $response->assertStatus(201)
            ->assertJsonFragment([
                'name' => 'Glory Ihe',
                'email' => 'glory.ihe@example.com',
            ]);
    }

    public function test_user_get()
    {
        $user = User::factory()->create();

        $response = $this->getJson("/api/v1/users/{$user->id}");

        $response->assertStatus(200);
    }

    public function test_user_update()
    {
        $user = User::factory()->create();

        $updateData = ['name' => 'Chijioke Nwachukwu'];

        $response = $this->putJson("/api/v1/users/{$user->id}", $updateData);

        $response->assertStatus(200)
            ->assertJsonFragment(['name' => 'Chijioke Nwachukwu']);
    }

    public function test_user_delete()
    {
        $user = User::factory()->create();

        $response = $this->deleteJson("/api/v1/users/{$user->id}");

        $response->assertStatus(204);
    }
}
