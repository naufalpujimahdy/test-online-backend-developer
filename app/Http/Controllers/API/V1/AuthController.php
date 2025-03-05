<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Service\AuthService;
use Exception;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
        $this->authService = $authService;
    }

    public function register(RegisterRequest $request)
    {
        try {
            $user = $this->authService->register($request->all());
            return response()->json([
                'message' => 'User registered successfully',
                'user' => $user,
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'An error occurred while registering the user',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');

        if (!$token = auth()->attempt($credentials)) {
            return response()->json([
                'message' => 'Unauthorized',
            ], 401);
        }

        return $this->respondWithToken($token);
    }

    public function me()
    {
        return response()->json(auth()->user());
    }

    public function logout()
    {
        auth()->logout();

        return response()->json([
            'success' => true,
            'message' => 'Successfully logged out'
        ]);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'success' => true,
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
