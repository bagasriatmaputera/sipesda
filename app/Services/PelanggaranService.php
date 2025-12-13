<?php

namespace App\Services;

use App\Repository\PelanggaranRepository;
use App\Models\Siswa;
use Illuminate\Support\Facades\DB;

class PelanggaranService
{
    public function __construct(
        protected PelanggaranRepository $repository
    ) {}

    public function getAll(array $fields)
    {
        return $this->repository->getAll($fields);
    }

    public function create(array $data)
    {
        return DB::transaction(function () use ($data) {

            $process = function ($item) {
                $pelanggaran = $this->repository->create($item);

                Siswa::where('id', $item['siswa_id'])
                    ->increment('total_poin', $item['poin']);

                return $pelanggaran;
            };

            if (isset($data[0])) {
                return collect($data)->map(fn($item) => $process($item));
            }

            return $process($data);
        });
    }

    public function getById(int $pelanggaranId)
    {
        return $this->repository->getById($pelanggaranId);
    }

    public function getBySiswa(int $siswaId)
    {
        return $this->repository->getBySiswaId($siswaId);
    }

    public function delete(int $id)
    {
        return $this->repository->delete($id);
    }
}
