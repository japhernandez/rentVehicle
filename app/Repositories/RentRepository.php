<?php


namespace App\Repositories;


use App\Models\Rent;
use App\UseCase\RentInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;

class RentRepository implements RentInterface
{
    /**
     * @var Rent
     */
    protected $model;

    /**
     * RentRepository constructor.
     * @param Rent $model
     */
    public function __construct(Rent $model)
    {
        $this->model = $model;
    }

    /**
     * @param array $data
     * @return JsonResponse
     */
    public function addRent(array $data)
    {
        return $this->model->create($data);
    }

    /**
     * @param $id
     * @return Rent
     */
    public function showRent($id): Rent
    {
        return $this->model->find($id);
    }

    /**
     * @return Rent
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
