<?php

namespace App\Repository;

use App\Models\Pelanggaran;

class PelanggaranRepository
{
    public function getAll(array $fields)
    {
        return Pelanggaran::select($fields)
            ->with(['siswa', 'guru', 'jenisPelanggaran'])
            ->latest()
            ->paginate(50);
    }

    public function getById(int $id)
    {
        return Pelanggaran::with(['siswa', 'guru', 'jenisPelanggaran'])
            ->findOrFail($id);
    }

    public function getBySiswaId(int $siswaId)
    {
        return Pelanggaran::where('siswa_id', $siswaId)
            ->latest()
            ->get();
    }

    public function create(array $data)
    {
        return Pelanggaran::create($data);
    }

    public function delete(int $id)
    {
        return Pelanggaran::findOrFail($id)->delete();
    }
}
