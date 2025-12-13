<?php

namespace App\Repository;

use App\Models\OrangTua;

class OrangTuaRepository
{
    public function getAll(array $fields)
    {
        return OrangTua::select($fields)->latest()->paginate(50);
    }

    public function getById(int $id)
    {
        return OrangTua::findOrFail($id);
    }

    public function getBySiswaId(int $siswaId)
    {
        return OrangTua::where('siswa_id', $siswaId)->first();
    }

    public function create(array $data)
    {
        return OrangTua::create($data);
    }

    public function update(int $id, array $data)
    {
        $orangTua = OrangTua::findOrFail($id);
        $orangTua->update($data);
        return $orangTua;
    }

    public function delete(int $id)
    {
        return OrangTua::findOrFail($id)->delete();
    }
}
