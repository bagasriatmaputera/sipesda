<?php

namespace App\Services;

use App\Repository\NotifikasiWaRepository;

class NotifikasiWaService
{
    public function __construct(
        protected NotifikasiWaRepository $repository
    ) {}

    public function getAll()
    {
        return $this->repository->getAll();
    }
    public function create(array $data)
    {
        if (isset($data[0])) {
            return collect($data)->map(
                fn($item) =>
                $this->repository->create($item)
            );
        }

        return $this->repository->create($data);
    }

    public function updateStatus(int $id, string $status)
    {
        return $this->repository->updateStatus($id, $status);
    }
}
