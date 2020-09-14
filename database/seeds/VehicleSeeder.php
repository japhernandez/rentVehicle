<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VehicleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $vehicles = [
            [
                "id" => 1,
                "license_plate" => "Zoe Hegmann",
                "color" => "MediumAquaMarine",
                "year" => "1995-04-01",
                "model" => "Miss Erica Bergnaum DVM",
                "rental_value" => 72292,
                "availability" => 1,
            ],
            [
                "id" => 2,
                "license_plate" => "Norbert Hahn III",
                "color" => "SaddleBrown",
                "year" => "2013-08-14",
                "model" => "Isadore Osinski Sr.",
                "rental_value" => 755768,
                "availability" => 0,
            ],
            [
                "id" => 3,
                "license_plate" => "Michaela Rath",
                "color" => "RoyalBlue",
                "year" => "1970-06-02",
                "model" => "Wanda Shields",
                "rental_value" => 704047,
                "availability" => 1,
            ],
            [
                "id" => 4,
                "license_plate" => "Dr. Marcelina Thiel III",
                "color" => "Blue",
                "year" => "2003-03-31",
                "model" => "Mr. Giuseppe Prohaska",
                "rental_value" => 321903,
                "availability" => 1,
            ],
            [
                "id" => 5,
                "license_plate" => "Wanda Greenfelder",
                "color" => "Peru",
                "year" => "2019-07-04",
                "model" => "Helen Stark DVM",
                "rental_value" => 380745,
                "availability" => 0,
            ]
        ];

        foreach($vehicles as $vehicle) DB::table('vehicles')->insert($vehicle);
    }
}
