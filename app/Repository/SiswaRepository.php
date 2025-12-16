<?php

namespace App\Repository;

use App\Models\Siswa;

class SiswaRepository
{
    public function getAll(array $fields)
    {
        return Siswa::select($fields)->latest()->paginate(50);
    }

    public function getById(int $siswaId)
    {
        return Siswa::where('id', $siswaId)->get();
    }

    public function create(array $data)
    {
        return Siswa::create($data);
    }

    public function update(int $siswaId, array $data)
    {
        $siswa = Siswa::findOrFail($siswaId);
        $siswa->update($data);
        return $siswa;
    }

    public function delete(int $siswaId)
    {
        $siswa = Siswa::findOrFail($siswaId);
        $siswa->delete();
        return $siswa;
    }
}
