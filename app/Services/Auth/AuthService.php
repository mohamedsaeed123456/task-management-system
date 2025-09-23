<?php

namespace App\Services\Auth;

use App\Contracts\Auth\AuthServiceInterface;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthService implements AuthServiceInterface
{
    /**
     * Authenticate user with email and password
     */
    public function authenticate(string $email, string $password): array
    {
        $user = User::where('email', $email)->first();
        
        if (!$user) {
            throw new \Exception('Email or password is incorrect', 401);
        }
        
        if (!Hash::check($password, $user->password)) {
            throw new \Exception('Email or password is incorrect', 401);
        }
        
        $token = $user->createToken('auth_token')->plainTextToken;
        
        return [
            'token' => $token,
            'user' => $user,
        ];
    }

    /**
     * Get authenticated user data
     */
    public function getAuthenticatedUser(Request $request): User
    {
        return $request->user();
    }

    /**
     * Logout user by revoking all tokens
     */
    public function logout(Request $request): bool
    {
        $request->user()->tokens()->delete();
        return true;
    }
}
