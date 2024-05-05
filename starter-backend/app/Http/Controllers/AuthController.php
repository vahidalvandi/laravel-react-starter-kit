<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Services\AuthService;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{

    protected AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * Register users
     * @param Request $request
     * @return JsonResponse
     */
    public function register(Request $request): JsonResponse
    {
        $validation = $this->authService->validate_registration($request->all());

        if(!$validation['success']){
            $response = [
                'status' => 'error',
                'message' => $validation['errors'],
            ];
            return response()->json($response, 200);
        }

        $validated_data = $validation['request'];

        try {

            $user = $this->authService->register($validated_data);

            $this->authService->sendPasswordResetLink($user);

        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create user. ' . $e->getMessage()
            ], 200);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'User registered successfully',
            'data' => $user,
        ], 200);
    }

    /**
     * @param Request $request
     * @return Response
     * @throws Exception
     */
    public function login(Request $request): Response
    {

        $validation = $this->authService->validate_login($request->all());

        if(!$validation['success']){

            return response()->json([
                'status' => 'error',
                'message' => $validation['errors'],
            ], 200);
        }

        $validated_data = $validation['request'];

        return $this->authService->login($validated_data);

    }

    /**
     * refresh token
     *
     * @param Request $request
     * @return false|Response
     * @throws Exception
     */
    public function refreshToken(Request $request): false|Response
    {

        $validation = $this->authService->validate_refresh_token($request->all());

        if(!$validation['success']){

            return response()->json([
                'status' => 'error',
                'message' => $validation['errors'],
            ], 200);
        }

        $validated_data = $validation['request'];

        return $this->authService->refresh_token($validated_data);

    }

    /**
     * Reset user password
     * @param Request $request
     * @return Response
     */
    public function resetPassword(Request $request): Response
    {
        $validation = $this->authService->validate_reset_password($request->all());

        if(!$validation['success']){

            return response()->json([
                'status' => 'error',
                'message' => $validation['errors'],
            ], 200);
        }

        $validated_data = $validation['request'];

        $status = $this->authService->reset_password($validated_data);

        if(!$status) {
            return response()->json([
                'status' => 'error',
                'message' => 'Password reset failed.',
            ], 200);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Password reset successful.',
        ], 200);
    }
}
