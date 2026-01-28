<?php
namespace App\Repository;

use App\Models\BobotRules;

class BobotRuleRepository
{
    public function getAll()
    {
        return BobotRules::with(['tahap:id,kode', 'kriteria:id,kode'])->get();
    }

    public function getById(int $bobotId)
    {
        return BobotRules::find($bobotId);
    }

    public function create(array $data)
    {
        $exists = BobotRules::where('tahap_id', $data['tahap_id'])
            ->where('kriteria_id', $data['kriteria_id'])
            ->exists();

        if ($exists) {
        throw new \Exception('Bobot untuk kriteria ini sudah ada di tahap terpilih.', 422);
    }

        return BobotRules::create($data);
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