<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Users\Student;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Support\Authentication;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase, Authentication;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_success_login()
    {
        $user = $this->createUser('secret');

        $response = $this->post('/auth/login', [
            'email' => $user->email,
            'password' => 'secret'
        ]);

        $response->assertStatus(200);
    }

    /**
     * Test failed login
     */
    public function test_failed_login()
    {
        $user = $this->createUser('secret');

        $response = $this->post('/auth/login', [
            'email' => $user->email,
            'password' => 'wrongpassword'
        ]);

        $response->assertStatus(401);
    }

    /**
     * Test with login
     */
    public function test_success_simulation_api() {
        $this->authenticated()
            ->json('get','/api/student/simulations')
            ->assertStatus(200);
    }

    /**
     * Test without login
     */
    public function test_failed_simulation_api() {
        $this->json('get','/api/student/simulations')
            ->assertStatus(401);
    }

    /**
     * Test with login
     */
    public function test_success_welcome_api() {
        $this->authenticated()
            ->json('get','/api/student/welcome')
            ->assertStatus(200);
    }

    /**
     * Test without login
     */
    public function test_failed_welcome_api() {
        $this->json('get','/api/student/welcome')
            ->assertStatus(401);
    }
}
