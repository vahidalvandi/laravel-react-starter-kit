<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Exception;

class UserService {
    protected UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Get user data
     * @throws Exception
     */
    public function get_user(): ?\Illuminate\Contracts\Auth\Authenticatable
    {
        return $this->userRepository->get_user();
    }

    /**
     * User logout
     * @return void
     */
    public function logout(): void
    {
        $this->userRepository->logout();
    }
}
