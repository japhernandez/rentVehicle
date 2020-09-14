<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterUserTest extends TestCase
{

    /** @test */
    public function it_user_register()
    {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->raw();
        $response = $this->post(route('api.auth.register'), $user);

        $response->assertStatus(201);
        $this->assertDatabaseHas('users', ['name' => $user['name']]);
    }

    /** @test */
    public function a_user_register_requires_a_name()
    {
        $this->withoutExceptionHandling();
        $response = $this->postJson(route('api.auth.register'), ['name' => '']);

        $response->assertStatus(422);
    }
}
