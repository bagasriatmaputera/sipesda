<?php

namespace App\Services;

use App\Repository\SiswaRepository;
use Illuminate\Support\Facades\DB;

class siswaService
{
    protected SiswaRepository $siswaRepository;

    public function __construct(SiswaRepository $siswaRepository)
    {
        $this->siswaRepository = $siswaRepository;
    }

    public function getAll(array $fields)
    {
        return $this->siswaRepository->getAll($fields);
    }

    public function getById(int $id)
    {
        return $this->siswaRepository->getById($id);
    }

    public function create(array $data)
    {
        return DB::transaction(function () use ($data) {
            // jika array of array → bulk insert
            if (isset($data[0]) && is_array($data[0])) {
                $result = [];
                foreach ($data as $item) {
                    $result[] = $this->siswaRepository->create($item);
                }
                return $result;
            }

            // single insert
            return $this->siswaRepository->create($data);
        });
    }

    public function update(int $id, array $data)
    {
        return $this->siswaRepository->update($id, $data);
    }

    public function delete(int $id)
    {
        return $this->siswaRepository->delete($id);
    }
}
