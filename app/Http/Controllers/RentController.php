<?php

namespace App\Http\Controllers;

use DateTime;
use App\Models\Rent;
use Illuminate\Http\Request;
use App\UseCase\RentInterface;
use App\UseCase\VehicleInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class RentController extends Controller
{
    /**
     * @var RentInterface
     */
    private $repository;

    /**
     * @var VehicleInterface
     */
    private $vehicle;

    /**
     * RentController constructor.
     * @param RentInterface $repository
     * @param VehicleInterface $vehicle
     */
    public function __construct(RentInterface $repository, VehicleInterface $vehicle)
    {
        $this->repository = $repository;
        $this->vehicle = $vehicle;
    }

    /**
     * @param $from
     * @param $to
     * @return JsonResponse
     */
    public function index($from, $to)
    {
        //TODO Refactorizar con Query Builder y Paginar
        $rents = Rent::whereBetween('created_at', [$from, $to])->get();
        Excel::download($rents, 'rents.csv', \Maatwebsite\Excel\Excel::CSV, [
            'Content-Type' => 'text/csv',
        ]);
        return response()->json($rents);
    }

    /**
     * @OA\Post(
     *   path="/api/v1/rents",
     *   tags={"Rents"},
     *   summary="Rents",
     *   operationId="rents",
     *
     *  @OA\Parameter(
     *      name="vehicle_id",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="integer"
     *      )
     *   ),
     *  @OA\Parameter(
     *      name="user_id",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="integer"
     *      )
     *   ),
     *   @OA\Parameter(
     *       name="delivery_date",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *   @OA\Parameter(
     *      name="departure_date",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *     @OA\Parameter(
     *       name="payment_method",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
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
     * @throws \Exception
     */
    public function store(Request $request)
    {
        //TODO Refactorizar las validaciones
        $validator = Validator::make($request->all(), [
            'vehicle_id' => 'required',
            'user_id' => 'required',
            'delivery_date' => 'required|date',
            'departure_date' => 'required|date',
            'payment_method' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        //TODO Refactorizar las validaciones
        $vehicle = $this->vehicle->showVehicle($request->vehicle_id);

        if ($vehicle->status === 0) {
            return response()->json(['message' => 'The vehicle you want to rent is not available'], 406);
        }

        $this->vehicle->updateVehicle(['status' => 0], $request->vehicle_id);

        $price = $this->calculatePrice($request);
        $params = ['total_price' => $price] + $request->all();
        $rent = $this->repository->addRent($params);

        return response()->json($rent, 201);
    }

    /**
     * @param $request
     * @return false|int
     * @throws \Exception
     */
    private function calculateDate($request)
    {
        $initialDate = new DateTime($request->delivery_date);
        $endDate = new DateTime($request->departure_date);
        $date = $initialDate->diff($endDate);
        return $date->days + 1;
    }

    /**
     * @param $request
     * @return float|int
     * @throws \Exception
     */
    private function calculatePrice($request)
    {
        $date = $this->calculateDate($request);
        $vehicle = $this->vehicle->showVehicle($request->vehicle_id);
        return $vehicle->rental_value * $date;
    }
}
