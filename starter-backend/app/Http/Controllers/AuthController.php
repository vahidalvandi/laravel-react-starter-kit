<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Function to register user
     *
     * @param Request $request
     * @return array
     */
    public function register(Request $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $response = [
            'status' => 'success',
            'message' => 'successfully Registered',
        ];

        return response()->json($response, 200);
    }

    /**
     * user login and issue access token
     *
     * @param Request $request
     * @return void
     */
    public function login(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $tokenRequest = Request::create('/oauth/token', 'POST', [
            'grant_type' => 'password',
            'client_id' => env('PASSPORT_PERSONAL_ACCESS_CLIENT_ID'),
            'client_secret' => env('PASSPORT_PERSONAL_ACCESS_CLIENT_SECRET'),
            'username' => $request->email,
            'password' => $request->password,
        ]);

        $response = app()->handle($tokenRequest);

        return $response;
    }

    /**
     * refresh token 
     *
     * @param Request $request
     * @return array
     */
    public function refreshToken(Request $request)
    {

        $validatedData = $request->validate([
            'refresh_token' => 'required|string',
        ]);

        $tokenRequest = Request::create('/oauth/token', 'POST', [
            'grant_type' => 'refresh_token',
            'refresh_token' => $validatedData['refresh_token'],
            'client_id' => env('PASSPORT_PERSONAL_ACCESS_CLIENT_ID'),
            'client_secret' => env('PASSPORT_PERSONAL_ACCESS_CLIENT_SECRET'),
        ]);

        $response = app()->handle($tokenRequest);

        return $response;
    }
}
