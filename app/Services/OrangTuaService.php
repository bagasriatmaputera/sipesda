<?php

namespace App\Services;

use App\Repository\OrangTuaRepository;
use Illuminate\Support\Facades\DB;

class OrangTuaService
{
    public function __construct(
        protected OrangTuaRepository $repository
    ) {}

    public function getBySiswa(int $siswaId)
    {
        return $this->repository->getBySiswaId($siswaId);
    }

    public function create(array $data)
    {
        return DB::transaction(function () use ($data) {
            if (isset($data[0])) {
                return collect($data)->map(
                    fn($item) =>
                    $this->repository->create($item)
                );
            }

            return $this->repository->create($data);
        });
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
