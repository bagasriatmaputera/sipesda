<?php

namespace App\Repository;

use App\Models\Siswa;

class SiswaRepository
{
    public function getAll(array $fields)
    {
        return Siswa::with('pelanggaran', 'kelas')->select($fields)->latest()->paginate(50);
    }

    public function getById(int $siswaId)
    {
        return Siswa::with(
            'pelanggaran',
            'kelas',
            'hasilSaw',
            'hasilSaw.tahap'
        )->where('id', $siswaId)->first();
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
