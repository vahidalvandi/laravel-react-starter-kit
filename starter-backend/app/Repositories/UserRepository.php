<?php

namespace App\Repositories;

use App\Models\User;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\Token;

/**
 * To work with user data
 */
class UserRepository
{
    /**
     * @param array $data
     * @return User
     * @throws Exception
     */
    public function register_user(array $data): User
    {
        try {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => bcrypt($data['password']),
            ]);
        } catch (QueryException $e) {
            throw new Exception('Failed to create user. ' . $e->getMessage());
        }

        return $user;
    }

    /**
     * Get user data
     * @throws Exception
     */
    public function get_user(): ?\Illuminate\Contracts\Auth\Authenticatable
    {

        try {
            $user = Auth::user();
        } catch (QueryException $e) {
            throw new Exception('Failed to get user. ' . $e->getMessage());
        }

        return $user;

    }

    /**
     * User logout
     * @return void
     */
    public function logout() {
        $user = Auth::user();
        $user->tokens->each(function (Token $token, $key) {
            $token->delete();
        });
    }

}
