<?php

namespace App\Repositories;

use App\Models\User;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
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

    /**
     * @param array $data
     * @return bool
     */
    public function reset_password(array $data): bool
    {

        try {
            $user  = $this->getUserByEmail($data['email']);
            // Delete existing tokens all logged in users will be forced to logout
            $user->tokens->each(function (Token $token, $key) {
                $token->delete();
            });
            $user->forceFill([
                'password' => bcrypt($data['password']),
                'remember_token' => null,
            ])->save();
            $user->markEmailAsVerified();
            return true;
        }
        catch (QueryException $e) {
            return false;
        }

    }

    /**
     * Get user by email
     * @param $email
     * @return mixed
     */
    public function getUserByEmail($email): mixed
    {
        return User::where('email', $email)->first();
    }

}
