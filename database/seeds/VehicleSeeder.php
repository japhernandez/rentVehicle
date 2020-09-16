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
                "license_plate" => "YTF-234",
                "color" => "Negro",
                "year" => "1995",
                "model" => "1995",
                "rental_value" => 35000,
                "availability" => 1,
                "status" => 1
            ],
            [
                "id" => 2,
                "license_plate" => "ZPR-908",
                "color" => "Blanco",
                "year" => "2013",
                "model" => "2013",
                "rental_value" => 50000,
                "availability" => 1,
                "status" => 1
            ],
            [
                "id" => 3,
                "license_plate" => "EDG-230",
                "color" => "Verde",
                "year" => "2019",
                "model" => "2019",
                "rental_value" => 74047,
                "availability" => 1,
                "status" => 1
            ],
            [
                "id" => 4,
                "license_plate" => "CEN-008",
                "color" => "Azul",
                "year" => "2003",
                "model" => "2003",
                "rental_value" => 32190,
                "availability" => 1,
                "status" => 1
            ],
            [
                "id" => 5,
                "license_plate" => "MMN-112",
                "color" => "Gris",
                "year" => "2019",
                "model" => "2019",
                "rental_value" => 80745,
                "availability" => 1,
                "status" => 1
            ],
            [
                "id" => 6,
                "license_plate" => "YTM-264",
                "color" => "Negro",
                "year" => "2009",
                "model" => "2009",
                "rental_value" => 35000,
                "availability" => 1,
                "status" => 1
            ],
            [
                "id" => 7,
                "license_plate" => "TTR-908",
                "color" => "Blanco",
                "year" => "2003",
                "model" => "2003",
                "rental_value" => 50000,
                "availability" => 1,
                "status" => 1
            ],
            [
                "id" => 8,
                "license_plate" => "PDG-230",
                "color" => "Verde",
                "year" => "2011",
                "model" => "2011",
                "rental_value" => 54000,
                "availability" => 1,
                "status" => 1
            ],
            [
                "id" => 9,
                "license_plate" => "CEN-108",
                "color" => "Azul",
                "year" => "2003",
                "model" => "2003",
                "rental_value" => 40000,
                "availability" => 1,
                "status" => 1
            ],
            [
                "id" => 10,
                "license_plate" => "MMN-002",
                "color" => "Gris",
                "year" => "2019",
                "model" => "2019",
                "rental_value" => 100000,
                "availability" => 1,
                "status" => 1
            ]
        ];

        foreach($vehicles as $vehicle) DB::table('vehicles')->insert($vehicle);
    }
}
