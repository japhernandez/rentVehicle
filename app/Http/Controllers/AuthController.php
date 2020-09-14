<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UseCase\UserInterface;
use Illuminate\Http\JsonResponse;
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
     * Get a JWT via given credentials.
     *
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

       return $this->createNewToken($token);
    }

    /**
     * Get the token array structure.
     *
     * @param string $token
     * @return JsonResponse
     */
    protected function createNewToken($token)
    {
        return response()->json([
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
        JWTAuth::logout();

        return response()->json(['message' => 'Successfully logged out']);
    }
}
