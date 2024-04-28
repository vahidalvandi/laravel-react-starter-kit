<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\Token;

class UserController extends Controller
{
    /**
     * Get the authenticated user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUser(Request $request)
    {

        $user = Auth::user();

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        return response()->json($user);
    }

    /**
     * request logout
     *
     * @return void
     */
    public function logout()
    {
        $user = Auth::user();
        $user->tokens->each(function (Token $token, $key) {
            $token->delete();
        });

        return response()->json(['message' => 'Logged out successfully']);
    }
}
