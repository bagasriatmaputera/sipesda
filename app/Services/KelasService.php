<?php

namespace App\Services;

use App\Repository\KelasRepository;
use Illuminate\Support\Facades\DB;
use Exception;

class KelasService
{
    protected $kelasRepository;

    public function __construct(KelasRepository $kelasRepository)
    {
        $this->kelasRepository = $kelasRepository;
    }

    public function getAllKelas()
    {
        return $this->kelasRepository->getAll();
    }

    public function getKelasById(int $id)
    {
        return $this->kelasRepository->getById($id);
    }

    public function storeKelas(array $data)
    {
        return DB::transaction(function () use ($data) {
            // Mendukung bulk insert jika data berupa array of arrays
            if (isset($data[0]) && is_array($data[0])) {
                return collect($data)->map(fn($item) => $this->kelasRepository->create($item));
            }
            return $this->kelasRepository->create($data);
        });
    }

    public function updateKelas(int $id, array $data)
    {
        return DB::transaction(function () use ($id, $data) {
            return $this->kelasRepository->update($id, $data);
        });
    }

    public function deleteKelas(int $id)
    {
        return $this->kelasRepository->delete($id);
    }
}
