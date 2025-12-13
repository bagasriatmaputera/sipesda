<?php

namespace App\Repository;

use App\Models\BatasPoin;

class BatasPoinRepository
{
    public function getAll()
    {
        return BatasPoin::orderBy('min_poin')->get();
    }

    public function getByPoint(int $totalPoint)
    {
        return BatasPoin::where('min_poin', '<=', $totalPoint)
            ->where('max_poin', '>=', $totalPoint)
            ->first();
    }

    public function create(array $data)
    {
        return BatasPoin::create($data);
    }

    public function update(int $id, array $data)
    {
        $batas = BatasPoin::findOrFail($id);
        $batas->update($data);
        return $batas;
    }

    public function delete(int $id)
    {
        return BatasPoin::findOrFail($id)->delete();
    }
}
