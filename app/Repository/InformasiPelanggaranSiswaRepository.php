<?php

namespace App\Repository;

use App\Models\InformasiPelanggaranSiswa;

class InformasiPelanggaranSiswaRepository
{
    public function getAll()
    {
        return InformasiPelanggaranSiswa::with([
            'kelas',
            'siswa',
            'siswa.pelanggaran'
        ])->select([
            'siswa_id',
            'kelas_id',
            'poin_pelanggaran',
            'tahap',
            'updated_at'
        ])->latest()->paginate(50);
    }

    public function getById(int $id)
    {
        return InformasiPelanggaranSiswa::with([
            'siswa',
            'kelas',
            'siswa.pelanggaran'
        ])
            ->where('id', $id)->first();
    }

    public function getBySiswa(string $namaSiswa)
    {
        return InformasiPelanggaranSiswa::with([
            'siswa',
            'kelas',
            'siswa.pelanggaran'
        ])
            ->whereHas('siswa', function ($query) use ($namaSiswa) {
                $query->where('namax', 'like', '%' . $namaSiswa . '%');
            })
            ->get();
    }

    public function getByKelas(int $kelas)
    {
        return InformasiPelanggaranSiswa::where('kelas_id', $kelas)->first();
    }

    // public function create(array $data)
    // {
    //     return InformasiPelanggaranSiswa::create($data);
    // }

    // public function update(int $id, array $data)
    // {
    //     $informasi = InformasiPelanggaranSiswa::findOrFail($id);
    //     $informasi->update($data);
    //     return $informasi;
    // }

    // public function delete(int $id)
    // {
    //     return InformasiPelanggaranSiswa::findOrFail($id)->delete();
    // }
}
