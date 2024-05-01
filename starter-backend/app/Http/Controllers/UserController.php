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
     * 
     * @OA\Get(
     *     path="/api/user",
     *     operationId="getUser",
     *     tags={"User"},
     *     summary="Get authenticated user's data",
     *     security={{"oauth2": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Schema(
     *                 schema="User",
     *                 title="User",
     *                 required={"id", "name", "email"}, 
     *                 @OA\Property(property="id", type="integer", format="int64", example=1),
     *                 @OA\Property(property="name", type="string", example="John Doe"),
     *                 @OA\Property(property="email", type="string", format="email", example="john@example.com"),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2024-05-02 12:00:00"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2024-05-02 12:00:00"),
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Unauthenticated")
     *         )
     *     )
     * )
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
