<?php


namespace App\Repositories;


use App\Models\Vehicle;
use App\UseCase\VehicleInterface;

class VehicleRepository implements VehicleInterface
{
    /**
     * @var Vehicle
     */
    protected $model;

    /**
     * VehicleRepository constructor.
     * @param Vehicle $model
     */
    public function __construct(Vehicle $model)
    {
        $this->model = $model;
    }

    /**
     * @return mixed
     */
    public function listVehicle()
    {
       return $this->model->all();
    }

    /**
     * @param array $data
     * @return Vehicle
     */
    public function addVehicle(array $data): Vehicle
    {
        return $this->model->create($data);
    }

    /**
     * @param $id
     * @return Vehicle
     */
    public function showVehicle($id): Vehicle
    {
        return $this->model->find($id);
    }

    /**
     * @param $id
     * @param $data
     * @return
     */
    public function updateVehicle(array $data, $id)
    {
       return $this->model->where('id', $id)->update($data);
    }

    /**
     * @param $id
     * @return bool|null
     * @throws \Exception
     */
    public function deleteVehicle($id)
    {
        return $this->model->delete($id);
    }

    /**
     * @return Vehicle
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @param $model
     * @return $this
     */
    public function setModel($model)
    {
        $this->model = $model;
        return $this;
    }
}
