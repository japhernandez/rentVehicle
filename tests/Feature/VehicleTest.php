<?php

namespace Tests\Feature;

use App\Models\Vehicle;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VehicleTest extends TestCase
{
    /** @test */
    public function it_vehicle_list_all()
    {
        $this->withoutExceptionHandling();
        factory(Vehicle::class)->create(['id' => mt_rand(500, 800)]);
        factory(Vehicle::class)->create(['id' => mt_rand(390, 490)]);
        $response = $this->get(route('api.vehicle.index'));

        $response->assertSuccessful();
    }

    /** @test */
    public function it_register_a_vehicle_an_authenticated_user()
    {
        $this->withoutExceptionHandling();
        $user = ['email' => 'john@gmail.com', 'password' => '123456'];
        $token = $this->post(route('api.auth.login'), $user);
        $vehicle = factory(Vehicle::class)->raw(['id' => mt_rand(200, 250)]);


        $response = $this->withHeader('Authorization', 'Bearer ' . $token['access_token'])->post(url('/api/vehicle'), $vehicle);
        $response->assertStatus(201);
        $this->assertDatabaseHas('vehicles', ['license_plate' => $vehicle['license_plate']]);
    }

    /** @test */
    public function it_required_fields_for_created_vehicle()
    {

        $user = ['email' => 'john@gmail.com', 'password' => '123456'];
        $token = $this->post(route('api.auth.login'), $user);
        $response = $this->withHeader('Authorization', 'Bearer ' . $token['access_token'])->post(url('/api/vehicle'), []);

        $response->assertStatus(422);
        $response->assertJson([
            "errors" => [
                "license_plate" => [
                    "The license plate field is required."
                ],
                "color" => [
                    "The color field is required."
                ],
                "year" => [
                    "The year field is required."
                ],
                "model" => [
                    "The model field is required."
                ],
                "rental_value" => [
                    "The rental value field is required."
                ],
                "availability" => [
                    "The availability field is required."
                ]
            ]
        ]);
    }

    /** @test */
    public function it_show_detail_a_vehicle_an_authenticated_user()
    {
        $vehicle = factory(Vehicle::class)->create(['id' => mt_rand(790, 940)]);
        $response = $this->get(route('api.vehicle.show', $vehicle['id']));

        $response->assertStatus(200);
    }

    /** @test */
    public function it_update_a_vehicle_an_authenticated_user()
    {
        $this->withoutExceptionHandling();
        $user = ['email' => 'john@gmail.com', 'password' => '123456'];
        $token = $this->post(route('api.auth.login'), $user);
        $vehicle = factory(Vehicle::class)->raw(['id' => mt_rand(200, 250)]);
        $response = $this->withHeader('Authorization', 'Bearer ' . $token['access_token'])->put(route('api.vehicle.update' , $vehicle['id']), $vehicle);

        $response->assertStatus(200);
        $response->assertJson(["message" => "Update successfully"]);
    }

    /** @test */
    public function it_required_fields_for_updated_vehicle()
    {

        $user = ['email' => 'john@gmail.com', 'password' => '123456'];
        $token = $this->post(route('api.auth.login'), $user);
        $response = $this->withHeader('Authorization', 'Bearer ' . $token['access_token'])->put(route('api.vehicle.update' , mt_rand(200, 250)), []);

        $response->assertStatus(422);
        $response->assertJson([
            "errors" => [
                "license_plate" => [
                    "The license plate field is required."
                ],
                "color" => [
                    "The color field is required."
                ],
                "year" => [
                    "The year field is required."
                ],
                "model" => [
                    "The model field is required."
                ],
                "rental_value" => [
                    "The rental value field is required."
                ],
                "availability" => [
                    "The availability field is required."
                ]
            ]
        ]);
    }

    /** @test */
    public function it_deleted_a_vehicle_an_authenticated_user()
    {
        $this->withoutExceptionHandling();
        $user = ['email' => 'john@gmail.com', 'password' => '123456'];
        $token = $this->post(route('api.auth.login'), $user);
        $vehicle = factory(Vehicle::class)->raw(['id' => mt_rand(200, 250)]);
        $response = $this->withHeader('Authorization', 'Bearer ' . $token['access_token'])->delete(route('api.vehicle.destroy' , $vehicle['id']), $vehicle);

        $response->assertStatus(200);
        $response->assertJson(["message" => "Deleted successfully"]);
    }
}
