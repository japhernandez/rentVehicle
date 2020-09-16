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
     * @OA\Get (
     ** path="/api/v1/vehicles",
     *   tags={"Vehicles"},
     *   summary="Vehicles",
     *   operationId="vehicles",
     *
     *
     *   @OA\Response(
     *      response=200,
     *       description="Success",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   ),
     *   @OA\Response(
     *      response=401,
     *      description="Unauthenticated"
     *   ),
     *   @OA\Response(
     *      response=400,
     *      description="Bad Request"
     *   ),
     *   @OA\Response(
     *      response=404,
     *      description="not found"
     *   ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *     security={ {"bearerAuth": {}} },
     *)
     **/

    /**
     * @return JsonResponse
     */
    public function index()
    {
        $vehicles = $this->repository->listVehicle();
        return response()->json($vehicles, 200);
    }

    /**
     * @OA\Post(
     *   path="/api/v1/vehicles",
     *   tags={"Vehicles"},
     *   summary="Vehicles",
     *   operationId="vehicles",
     *
     *   @OA\Parameter(
     *      name="license_plate",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *   @OA\Parameter(
     *      name="color",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *   @OA\Parameter(
     *      name="year",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="integer"
     *      )
     *   ),
     *   @OA\Parameter(
     *      name="model",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="integer"
     *      )
     *   ),
     *   @OA\Parameter(
     *       name="rental_value",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="integer"
     *      )
     *   ),
     *   @OA\Response(
     *      response=201,
     *       description="Success",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   ),
     *   @OA\Response(
     *      response=401,
     *       description="Unauthenticated"
     *   ),
     *   @OA\Response(
     *      response=400,
     *      description="Bad Request"
     *   ),
     *   @OA\Response(
     *      response=404,
     *      description="Not found"
     *   ),
     *    @OA\Response(
     *       response=403,
     *       description="Forbidden"
     *   ),
     *      security={ {"bearerAuth": {}} },
     *)
     **/

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
     * @OA\Get (
     ** path="/api/v1/vehicles/{id}",
     *   tags={"Vehicles"},
     *   summary="Vehicle Detail",
     *   operationId="vehicledetails",
     *
     *   @OA\Parameter(
     *      name="id",
     *      in="path",
     *      required=true,
     *      @OA\Schema(
     *           type="integer"
     *      )
     *   ),
     *
     *   @OA\Response(
     *      response=200,
     *       description="Success",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   ),
     *   @OA\Response(
     *      response=401,
     *      description="Unauthenticated"
     *   ),
     *   @OA\Response(
     *      response=400,
     *      description="Bad Request"
     *   ),
     *   @OA\Response(
     *      response=404,
     *      description="not found"
     *   ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      security={ {"bearerAuth": {}} },
     *)
     **/
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
            'year' => 'required',
            'model' => 'required',
            'rental_value' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $this->repository->updateVehicle($request->all(), $id);
        return response()->json([ "message" => "Update successfully"], 200);
    }

    /**
     * @OA\Delete (
     ** path="/api/v1/vehicles/{id}",
     *   tags={"Vehicles"},
     *   summary="Vehicle Delete",
     *   operationId="vehicledelete",
     *
     *   @OA\Parameter(
     *      name="id",
     *      in="path",
     *      required=true,
     *      @OA\Schema(
     *           type="integer"
     *      )
     *   ),
     *
     *   @OA\Response(
     *      response=200,
     *       description="Success",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   ),
     *   @OA\Response(
     *      response=401,
     *      description="Unauthenticated"
     *   ),
     *   @OA\Response(
     *      response=400,
     *      description="Bad Request"
     *   ),
     *   @OA\Response(
     *      response=404,
     *      description="not found"
     *   ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      security={ {"bearerAuth": {}} },
     *)
     **/

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
