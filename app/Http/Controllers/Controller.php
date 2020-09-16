<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    /**
     * @OA\Info(
     *      version="1.0.0",
     *      title="Integration Swagger in Laravel with Jwt Auth Documentation",
     *      description="Implementation of Swagger with in Laravel"
     * )
     */
    /**
     * @OA\SecurityScheme(
     *   securityScheme="bearerAuth",
     *   type="http",
     *   scheme="bearer",
     *   bearerFormat="JWT",
     *)
     */
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
