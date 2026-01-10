<?php

namespace App\Services;

use App\Repository\InformasiPelanggaranSiswaRepository;

class InformasiPelanggaranSiswaService
{
    public function __construct(
        protected InformasiPelanggaranSiswaRepository $repository
    ) {}

    public function getAll()
    {
        return $this->repository->getAll();
    }

    public function getById(int $id)
    {
        return $this->repository->getById($id);
    }

    public function getBySiswa(string $siswa)
    {
        return $this->repository->getBySiswa($siswa);
    }

    public function getByKelas(int $kelas)
    {
        return $this->repository->getByKelas($kelas);
    }

    // public function create(array $data)
    // {
    //     return $this->repository->create($data);
    // }

    // public function update(int $id, array $data)
    // {
    //     return $this->repository->update($id, $data);
    // }

    // public function delete(int $id)
    // {
    //     return $this->repository->delete($id);
    // }
}
