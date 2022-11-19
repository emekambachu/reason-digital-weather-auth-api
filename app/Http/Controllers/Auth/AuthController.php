<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ValidateLoginRequest;
use App\Http\Requests\Auth\ValidateRegistrationRequest;
use App\Services\AuthService;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     * Include Dependency injection for AuthService Class
     * @return void
     */
    protected AuthService $auth;
    public function __construct(AuthService $auth) {
        $this->auth = $auth;
        // Authenticate all methods except login and register
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    /**
     * Get a JWT via given credentials.
     * Include ValidationLoginRequest Class
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(ValidateLoginRequest $request): \Illuminate\Http\JsonResponse
    {
        try {
            $data = $this->auth->loginUser($request);
            return response()->json($data);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * Register a User.
     * Include ValidateRegistrationRequest Class
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(ValidateRegistrationRequest $request): \Illuminate\Http\JsonResponse
    {
        try {
            $data = $this->auth->registerUser($request);
            return response()->json($data);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(): \Illuminate\Http\JsonResponse
    {
        try {
            Auth::guard('api')->logout();
            return response()->json([
                'success' => true,
                'message' => 'Logged out'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh(): \Illuminate\Http\JsonResponse
    {
        try {
            $data = $this->auth->createNewToken(Auth::guard('api')->refresh());
            return response()->json($data);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function profile(): \Illuminate\Http\JsonResponse
    {
        try {
            return response()->json(Auth::guard('api')->user());

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }

    }

}
