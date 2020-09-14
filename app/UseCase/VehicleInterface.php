<?php


namespace App\UseCase;


use App\Models\Vehicle;

interface VehicleInterface
{
    /**
     * @return mixed
     */
    public function listVehicle();

    /**
     * @param array $data
     * @return Vehicle
     */
    public function addVehicle(array $data): Vehicle;

    /**
     * @param $id
     * @return Vehicle
     */
    public function showVehicle($id): Vehicle;

    /**
     * @param $id
     * @param $data
     * @return Vehicle
     */
    public function updateVehicle(array $data, $id);

    /**
     * @param $id
     */
    public function deleteVehicle($id);
}
