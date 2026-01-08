<?php

namespace App\Repository;

use App\Models\Kelas;

class KelasRepository
{
    public function getAll()
    {
        // Mengambil kelas beserta informasi guru (wali kelas)
        return Kelas::with('guru')->latest()->paginate(50);
    }

    public function getById(int $id)
    {
        return Kelas::with(['guru', 'siswa'])->findOrFail($id);
    }

    public function create(array $data)
    {
        return Kelas::create($data);
    }

    public function update(int $id, array $data)
    {
        $kelas = Kelas::findOrFail($id);
        $kelas->update($data);
        return $kelas;
    }

    public function delete(int $id)
    {
        $kelas = Kelas::findOrFail($id);
        $kelas->delete();
        return $kelas;
    }
}
