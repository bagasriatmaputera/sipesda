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
        return Pelanggaran::with([
            'siswa:id,nama,kelas_id',
            'guru:id,nama_guru',
            'siswa.kelas:id,nama_kelas',
            'jenisPelanggaran:id,nama_pelanggaran,kategori,poin'
        ])
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

    public function update(int $id, array $data)
    {
        $pelanggaran = Pelanggaran::findOrFail($id);
        $pelanggaran->update($data);
        return $data;
    }

    public function delete(int $id)
    {
        return Pelanggaran::findOrFail($id)->delete();
    }
}
