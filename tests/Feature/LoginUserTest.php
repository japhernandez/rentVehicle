<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginUserTest extends TestCase
{
    /** @test */
    public function an_user_login_requires_an_email()
    {
        $this->withoutExceptionHandling();
        $response = $this->postJson(route('api.auth.login'), ['email' => '']);

        $response->assertStatus(422);
    }

    /** @test */
    public function it_user_login()
    {
        $this->withoutExceptionHandling();
        $user = ['email' => 'john@gmail.com', 'password' => '123456'];
        $response = $this->post(route('api.auth.login'), $user);

        $response->assertStatus(200);
        $response->assertJson([
            "access_token" => $response['access_token'],
            "token_type" => "bearer",
            "expires_in" => 3600
        ]);
    }
}
