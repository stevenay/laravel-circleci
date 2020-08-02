<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    use WithFaker;

    private $password = 'mypassword';

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testUserCreation()
    {
        $this->withoutExceptionHandling();

        $name = $this->faker->name();
        $email = $this->faker->email();

        $response = $this->postJson('/api/auth/signup', [
            'name' => $name,
            'email' => $email,
            'password' => $this->password,
            'password_confirmation' => $this->password
        ]);

        $response
            ->assertStatus(201)
            ->assertExactJson([
                'message' => 'Successfully created user!',
            ]);
    }
}
