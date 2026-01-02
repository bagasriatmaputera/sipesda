<?php

namespace App\Services;

use App\Repository\UserRoleAssignRepository;

class UserAssignRoleService
{
    public function __construct(protected UserRoleAssignRepository $repo) {}

    public function assignRoleToUser(int $userId, int $roleId)
    {
        return $this->repo->assignRoleToUser($userId, $roleId);
    }

    public function removeRoleUser(int $userId, int $roleId)
    {
        return $this->repo->removeRoleToUser($userId, $roleId);
    }

    public function getRoleUser(int $userId)
    {
        return $this->repo->getUserRole($userId);
    }
}
