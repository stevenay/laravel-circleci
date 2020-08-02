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

    public function testUserLogin()
    {
        $name = $this->faker->name();
        $email = $this->faker->email();

        $user = new User([
            'name' => $name,
            'email' => $email,
            'password' => bcrypt($this->password)
        ]);

        $user->save();

        $response = $this->postJson('/api/auth/login', [
            'email' => $email,
            'password' => $this->password
        ]);

        $response->assertStatus(200);
        $this->assertAuthenticated();
    }
}
