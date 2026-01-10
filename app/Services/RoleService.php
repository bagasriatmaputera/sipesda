<?php

namespace App\Services;

use App\Repository\RoleRepository;

class RoleService
{
    public function __construct(protected RoleRepository $roleRepository) {}

    public function getAll()
    {
        return $this->roleRepository->getAll();
    }

    public function create($data)
    {
        return $this->roleRepository->create($data);
    }

    public function update(int $id, $data)
    {
        return $this->roleRepository->update($id, $data);
    }

    public function delete(int $id)
    {
        return $this->roleRepository->delete($id);
    }
}
