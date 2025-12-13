<?php

namespace App\Services;

use App\Repository\TemplatePesanRepository;

class TemplatePesanService
{
    public function __construct(
        protected TemplatePesanRepository $repository
    ) {}

    public function getAll()
    {
        return $this->repository->getAll();
    }
    public function getActive()
    {
        return $this->repository->getActive();
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
