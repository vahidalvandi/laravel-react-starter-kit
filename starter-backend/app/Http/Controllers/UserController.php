<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\Token;

/**
 * User specific data controller
 */
class UserController extends Controller
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Fetch user data
     * @param Request $request
     * @return JsonResponse
     */
    public function getUser(Request $request): JsonResponse
    {

        try {
            $user = $this->userService->get_user();
        }
        catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create user. ' . $e->getMessage()
            ], 200);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Successfully fetched user',
            'data' => $user,
        ], 200);

    }

    /**
     * Request logout
     *
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        try {
            $this->userService->logout();
        }
        catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to log out. ' . $e->getMessage()
            ], 200);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out',
        ], 200);

    }
}
