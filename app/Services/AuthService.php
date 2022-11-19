<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

/**
 * Class AuthService.
 */
class AuthService
{
    // Dependency injection for User service class
    protected UserService $user;
    public function __construct(UserService $user){
        $this->user = $user;
    }

    /**
     * Register user with user function from the UserService Class
     * Return data to controller in array
     */
    public function registerUser($request): array
    {
        $user = $this->user->user()->create(array_merge(
            $request->all(),
            ['password' => bcrypt($request->password)]
        ));
        return [
            'success' => true,
            'user' => $user,
            'message' => 'User successfully registered',
        ];
    }

    /**
     * Get the token array structure.
     *  Create token function and return data as array
     *
     * check if user credentials are correct and generate token
     * return token to AuthController
     */
    public function loginUser($request): array
    {
        $token = Auth::guard('api')->attempt($request->only('email', 'password'));
        if(!$token){
            return [
                'success' => false,
                'message' => 'Username or password is incorrect',
            ];
        }
        return $this->createNewToken($token);
    }

    /**
     * Get the token array structure.
     *  Create token function and return data as array
     * @param string $token
     *
     * @return array
     */
    public function createNewToken(string $token): array
    {
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::guard('api')->factory()->getTTL() * 60,
            'user' => Auth::guard('api')->user()
        ];
    }
}
