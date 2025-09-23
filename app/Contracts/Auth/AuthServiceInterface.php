<?php

namespace App\Contracts\Auth;

use App\Models\User;
use Illuminate\Http\Request;

interface AuthServiceInterface
{
    /**
     * Authenticate user with email and password
     */
    public function authenticate(string $email, string $password): array;

    /**
     * Get authenticated user data
     */
    public function getAuthenticatedUser(Request $request): User;

    /**
     * Logout user by revoking all tokens
     */
    public function logout(Request $request): bool;
}
