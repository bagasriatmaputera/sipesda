<?php
namespace App\Repository;

use App\Models\BobotRules;

class BobotRuleRepository
{
    public function getAll()
    {
        return BobotRules::select(
            'id',
            'tahap_id',
            'kriteria_id',
            'bobot'
        )->get();
    }

    public function getById(int $bobotId)
    {
        return BobotRules::find($bobotId);
    }

    public function create(array $data)
    {
        $makeSure = BobotRules::where('kriteria_id', $data['kriteria_id'])->where('tahap_id', $data['tahap_id'])->exists();
        if ($makeSure) {
            throw new \Exception('Tahap dengan kriteria tersebut sudah diset, tidak bisa tambah bobot');
            return;
        }
        $rules = BobotRules::create($data);
        return $rules;
    }

    public function update(int $bobotId, array $data)
    {
        $bobot = BobotRules::findOrFail($bobotId);
        $bobot->update($data);
        return $bobot;
    }

    public function delete(int $bobotId)
    {
        $bobot = BobotRules::findOrFail($bobotId);
        $bobot->delete();
        return $bobot;
    }
}