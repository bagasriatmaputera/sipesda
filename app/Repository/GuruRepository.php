<?php

namespace App\Repository;

use App\Models\Guru;

class GuruRepository
{
    public function getAll()
    {
        return Guru::select(
            'user_id',
            'nip',
            'nama_guru',
            'kelas_id',
            'no_hp',
        )->latest()->paginate(50);
    }

    public function getById(int $id)
    {
        return Guru::findOrFail($id);
    }

    public function create(array $data)
    {
        return Guru::create($data);
    }

    public function update(int $id, array $data)
    {
        $guru = Guru::findOrFail($id);
        $guru->update($data);
        return $guru;
    }

    public function delete(int $id)
    {
        $guru = Guru::findOrFail($id);
        $guru->delete();
        return $guru;
    }
}
