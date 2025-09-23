<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\LoginRequest;
use App\Contracts\Auth\AuthServiceInterface;
use App\Helpers\ApiResponse;

class AuthController extends Controller
{
    protected $authService;

    /**
     * Constructor - Dependency Injection
     */
    public function __construct(AuthServiceInterface $authService)
    {
        $this->authService = $authService;
    }

    /**
     * Authenticate user and return token
     */
    public function login(LoginRequest $request)
    {
        try {
            $validated = $request->validated();
            
            $data = $this->authService->authenticate(
                $validated['email'], 
                $validated['password']
            );
            
            return ApiResponse::success('Login successful', $data);
            
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), null, $e->getCode() ?: 401);
        }
    }

    /**
     * Get authenticated user data
     */
    public function me(Request $request)
    {
        try {
            $user = $this->authService->getAuthenticatedUser($request);
            return ApiResponse::success('User retrieved successfully', $user);
            
        } catch (\Exception $e) {
            return ApiResponse::error('Failed to retrieve user data', null, 500);
        }
    }
    
    /**
     * Logout user and revoke tokens
     */
    public function logout(Request $request)
    {
        try {
            $this->authService->logout($request);
            return ApiResponse::success('Logged out successfully');
            
        } catch (\Exception $e) {
            return ApiResponse::error('Failed to logout', null, 500);
        }
    }
}
