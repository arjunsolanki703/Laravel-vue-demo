<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\User;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    /* public function test_example()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    } */

    // use RefreshDatabase;

    public function testRequiredFieldsForLogin()
    {
        $res = $this->json('POST', 'api/login')
            ->assertStatus(422)
            ->assertJson([
                "message" => "The given data was invalid.",
                "errors" => [
                    "username" => ["The username field is required."],
                    "password" => ["The password field is required."],
                ]
            ]);
    }

    public function testSuccessfulLogin()
    {
        $user = User::factory()->create([
            "username" => "admin",
            'first_name' => 'john',
            'last_name' => 'doe',
            'role' => 'standard_user',
            'password' => bcrypt('12345678'),
         ]);
        $userData = [
            "username" => "admin",
            "password" => "12345678",
        ];

        $res = $this->json('POST', 'api/login', $userData, ['Accept' => 'application/json']);
        $res->assertStatus(200)
        ->assertJsonStructure([
            "success",
            "data" => [
                'id',
                'first_name',
                'last_name',
                'username',
                'role',
                'created_at',
                'updated_at',
                "token"
            ],
            "message"
        ]);
        $this->assertAuthenticated();
    }
}