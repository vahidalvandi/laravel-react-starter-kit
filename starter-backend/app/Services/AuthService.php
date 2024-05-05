<?php

namespace App\Services;

use App\Models\User;
use App\Notifications\PasswordResetNotification;
use App\Repositories\UserRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class AuthService
{
    protected UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param array $request
     * @return array
     */
    public function validate_registration(array $request): array
    {
        $validator = Validator::make($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return [
                'success' => false,
                'errors' => $validator->errors()->toArray()
            ];
        }

        $sanitized_data = GeneralService::sanitize_data($request);

        return [
            'success' => true,
            'request' => $sanitized_data,
        ];

    }

    /**
     * @param array $request
     * @return array
     */
    public function validate_login(array $request): array
    {
        $customMessages = [
            'email.required' => 'The email is required.',
            'email.email' => 'The email must be a valid email address.',
        ];

        $validator = Validator::make($request, [
            'email' => 'required|email',
            'password' => 'required',
        ], $customMessages);

        if ($validator->fails()) {
            return [
                'success' => false,
                'errors' => $validator->errors()->toArray()
            ];
        }

        $sanitized_data = GeneralService::sanitize_data($request);

        return [
            'success' => true,
            'request' => $sanitized_data,
        ];

    }

    /**
     * @param array $request
     * @return array
     */
    public function validate_refresh_token(array $request): array
    {

        $validator = Validator::make($request, [
            'refresh_token' => 'required|string',
        ]);

        if ($validator->fails()) {
            return [
                'success' => false,
                'errors' => $validator->errors()->toArray()
            ];
        }

        $sanitized_data = GeneralService::sanitize_data($request);

        return [
            'success' => true,
            'request' => $sanitized_data,
        ];

    }

    /**
     * Reset password request validation
     * @param array $request
     * @return array
     */
    public function validate_reset_password(array $request): array
    {

        $validator = Validator::make($request, [
            'email' => 'required|email',
            'token' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return [
                'success' => false,
                'errors' => $validator->errors()->toArray()
            ];
        }

        $sanitized_data = GeneralService::sanitize_data($request);

        return [
            'success' => true,
            'request' => $sanitized_data,
        ];

    }

    /**
     * @param array $data
     * @return User
     * @throws Exception
     */
    public function register(array $data): User
    {
        return $this->userRepository->register_user($data);
    }

    /**
     * @param array $data
     * @return Response|false
     * @throws Exception
     */
    public function login(array $data): false|Response
    {

        try {
            $tokenRequest = Request::create('/oauth/token', 'POST', [
                'grant_type' => 'password',
                'client_id' => env('PASSPORT_PERSONAL_ACCESS_CLIENT_ID'),
                'client_secret' => env('PASSPORT_PERSONAL_ACCESS_CLIENT_SECRET'),
                'username' => $data['email'],
                'password' => $data['password'],
            ]);

        }
        catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to login. ' . $e->getMessage()
            ], 200);
        }

        return app()->handle($tokenRequest);

    }

    /**
     * @param array $data
     * @return false|Response
     * @throws Exception
     */
    public function refresh_token(array $data): false|Response
    {

        try {
            $tokenRequest = Request::create('/oauth/token', 'POST', [
                'grant_type' => 'refresh_token',
                'refresh_token' => $data['refresh_token'],
                'client_id' => env('PASSPORT_PERSONAL_ACCESS_CLIENT_ID'),
                'client_secret' => env('PASSPORT_PERSONAL_ACCESS_CLIENT_SECRET'),
            ]);

        }
        catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to get refresh token. ' . $e->getMessage()
            ], 200);
        }

        return app()->handle($tokenRequest);

    }

    /**
     * Password reset notification send
     * @param User $user
     * @return void
     */
    public function sendPasswordResetLink(User $user): void
    {

        $token = Password::createToken($user);
        $user->notify(new PasswordResetNotification($token));
    }

    /**
     * @param array $data
     * @return bool
     */
    public function reset_password(array $data): bool
    {
        return $this->userRepository->reset_password($data);
    }
}
