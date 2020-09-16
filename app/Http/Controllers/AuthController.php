<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\UseCase\UserInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Validator;


class AuthController extends Controller
{
    private $repository;

    /**
     * Create a new AuthController instance.
     *
     * @param UserInterface $repository
     */
    public function __construct(UserInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Register a User.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|between:2,100',
            'email' => 'required|email|unique:users|max:50',
            'password' => 'required|string|min:6',
            'document' => 'required|integer|min:8|unique:users'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $params = ['password' => bcrypt($request->password)] + $request->all();
        $user = $this->repository->addUser($params);

        return response()->json(['message' => 'Successfully registered', 'user' => $user], 201);
    }

    /**
     * @OA\Post(
     ** path="/api/v1/login",
     *   tags={"Login"},
     *   summary="Login",
     *   operationId="login",
     *   security={
     *      {"jwt": {}},
     *   },
     *   @OA\Parameter(
     *      name="email",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *   @OA\Parameter(
     *      name="password",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="string"
     *      )
     *   ),
     *   @OA\Response(
     *      response=200,
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
     *      description="not found"
     *   ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *)
     **/

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = $request->only("email", "password");

        $validator = Validator::make($credentials, [
            'email' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        if (!$token = JWTAuth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        $user = auth()->user();

       return $this->createNewToken($token, $user);
    }

    /**
     * Get the token array structure.
     *
     * @param string $token
     * @param $user
     * @return JsonResponse
     */
    protected function createNewToken($token, $user)
    {
        return response()->json([
            'user' => $user,
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60
        ], 200);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return JsonResponse
     */
    public function logout()
    {
        auth()->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * @return JsonResponse
     */
    public function users()
    {
        $users = User::all();
        return response()->json($users);
    }
}
