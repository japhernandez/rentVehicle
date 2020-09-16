<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UseCase\VehicleInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class VehicleController extends Controller
{
    /**
     * @var VehicleInterface
     */
    private $repository;

    /**
     * VehicleController constructor.
     * @param VehicleInterface $repository
     */
    public function __construct(VehicleInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return JsonResponse
     */
    public function index()
    {
        $vehicles = $this->repository->listVehicle();
        return response()->json($vehicles, 200);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        //TODO Refactorizar las validaciones
        $validator = Validator::make($request->all(), [
            'license_plate' => 'required|unique:vehicles|max:50',
            'color' => 'required|between:2,50',
            'year' => 'required',
            'model' => 'required',
            'rental_value' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $vehicle = $this->repository->addVehicle($request->all());
        return response()->json($vehicle, 201);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function show($id)
    {
        $vehicle = $this->repository->showVehicle($id);
        return response()->json($vehicle, 200);
    }

    /**
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        //TODO Refactorizar las validaciones
        $validator = Validator::make($request->all(), [
            'license_plate' => 'required|unique:vehicles|max:50'. $id,
            'color' => 'required|between:2,50',
            'year' => 'required|number',
            'model' => 'required|number',
            'rental_value' => 'number'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $this->repository->updateVehicle($request->all(), $id);
        return response()->json([ "message" => "Update successfully"], 200);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $this->repository->deleteVehicle($id);
        return response()->json([ "message" => "Deleted successfully"], 200);
    }
}
