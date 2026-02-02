<?php

namespace App\Repository;

use App\Models\Siswa;

class SiswaRepository
{
    public function getAll()
    {
        return Siswa::with('pelanggaran', 'kelas', 'hasilSaw')->latest()->paginate(50);
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
        $siswa->update([
            'nama' => $data['nama'] ?? $siswa->nama,
            'kelas_id' => $data['kelas_id'] ?? $siswa->kelas_id,
            'nama_wali' => $data['nama_wali'] ?? $siswa->nama_wali,
            'no_hp_wali' => $data['no_hp_wali'] ?? $siswa->no_hp_wali,
            'photo' => $data['photo'] ?? $siswa->photo,
        ]);
        return $siswa;
    }

    public function delete(int $siswaId)
    {
        $siswa = Siswa::findOrFail($siswaId);
        $siswa->delete();
        return $siswa;
    }
}
