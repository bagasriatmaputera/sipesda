<?php

namespace App\Repository;

use App\Models\Guru;

class GuruRepository
{
    public function getAll()
    {
        return Guru::with(['users', 'kelas'])
            ->latest()->paginate(50);
    }

    public function getById($id)
    {
        return Guru::with(['users', 'kelas'])->findOrFail($id);
    }

    public function create(array $data)
    {
        return Guru::create($data);
    }

    public function update(int $id, array $data)
    {
        $guru = Guru::findOrFail($id);
        $guru->update([
            'nama_guru' => $data['nama_guru'] ?? $guru->nama_guru,
            'nip' => $data['nip'] ?? $guru->nip,
            'photo' => $data['photo'] ?? $guru->photo,
            'kelas_id' => $data['kelas_id'] ?? $guru->kelas_id,
            'no_hp' => $data['no_hp'] ?? $guru->no_hp,
        ]);
        return $guru;
    }

    public function delete(int $id)
    {
        $guru = Guru::findOrFail($id);
        $guru->delete();
        return $guru;
    }
}
