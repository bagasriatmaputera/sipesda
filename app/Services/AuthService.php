<?php

namespace App\Services;

use App\Repository\AuthRepository;

class AuthService
{
    public function __construct(protected AuthRepository $authRepository) {}

    public function register(array $data)
    {
        return $this->authRepository->create($data);
    }

    public function login(array $data)
    {
        return $this->authRepository->login($data);
    }

    public function tokenLogin($data)
    {
        return $this->authRepository->tokenLogin($data);
    }

    public function tokenLogout(){
        return $this->authRepository->tokenLogout();
    }
}
