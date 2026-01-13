<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Login user and return access token
     */
    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if (!Auth::attempt($validated)) {
            return response()->json([
                'message' => 'Invalid credentials'
            ], 401);
        }

        $user = $request->user();
        $token = $user->createToken('API Token')->accessToken;

        return response()->json([
            'message' => 'Login successful',
            'token' => $token,
            'user' => $user->load('roles')
        ]);
    }

    /**
     * Get authenticated user with roles
     */
    public function me(Request $request)
    {
        return response()->json([
            'user' => $request->user()->load('roles', 'permissions')
        ]);
    }

    /**
     * Logout user and revoke tokens
     */
    public function logout(Request $request)
    {
        // Revoke current token
        $request->user()->token()->revoke();

        return response()->json([
            'message' => 'Logged out successfully'
        ]);
    }

    /**
     * Get all tokens for the authenticated user
     */
    public function tokens(Request $request)
    {
        return response()->json([
            'tokens' => $request->user()->tokens
        ]);
    }

    /**
     * Revoke a specific token
     */
    public function revokeToken(Request $request, $tokenId)
    {
        $request->user()
            ->tokens()
            ->where('id', $tokenId)
            ->delete();

        return response()->json([
            'message' => 'Token revoked successfully'
        ]);
    }
}
