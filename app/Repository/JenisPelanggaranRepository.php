<?php

namespace App\Repository;

use App\Models\JenisPelanggaran;

class JenisPelanggaranRepository
{
    public function getAll()
    {
        return JenisPelanggaran::with(['tingkatPelanggaran:id,tingkat,nilai'])
            ->select(['id', 'nama_pelanggaran', 'tingkat_pelanggaran_id', 'poin'])
            ->orderBy('poin')
            ->paginate(50);
    }

    public function getById(int $id)
    {
        return JenisPelanggaran::findOrFail($id);
    }

    public function create(array $data)
    {
        return JenisPelanggaran::create($data);
    }

    public function update(int $id, array $data)
    {
        $jenis = JenisPelanggaran::findOrFail($id);
        $jenis->update($data);
        return $jenis;
    }

    public function delete(int $id)
    {
        return JenisPelanggaran::findOrFail($id)->delete();
    }
}
