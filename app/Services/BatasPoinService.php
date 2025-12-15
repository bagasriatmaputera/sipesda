<?php

namespace App\Services;

use App\Repository\BatasPoinRepository;

class BatasPoinService
{
    public function __construct(
        protected BatasPoinRepository $repository
    ) {}

    public function getAll()
    {
        return $this->repository->getAll();
    }

    public function getByTotalPoint(int $point)
    {
        return $this->repository->getByPoint($point);
    }

    public function create(array $data)
    {
        return $this->repository->create($data);
    }

    public function update(int $id, array $data)
    {
        return $this->repository->update($id, $data);
    }

    public function delete(int $id)
    {
        return $this->repository->delete($id);
    }
}
