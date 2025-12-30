<?php

namespace App\Services;

use App\Repository\JenisPelanggaranRepository;
use Illuminate\Support\Facades\DB;

class JenisPelanggaranService
{
    public function __construct(
        protected JenisPelanggaranRepository $repository
    ) {}

    public function getAll(array $fields)
    {
        return $this->repository->getAll($fields);
    }

    public function create(array $data)
    {
        return DB::transaction(function () use ($data) {
            if (isset($data[0]) && is_array($data[0])) {
                $result = [];
                foreach ($data as $jenisPel) {
                    $result[] = $this->repository->create($jenisPel);
                }
                return $result;
            }

            return $this->repository->create($data);
        });
    }

    public function getById(int $id)
    {
        return $this->repository->getById($id);
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
