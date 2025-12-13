<?php

namespace App\Repository;

use App\Models\NotifikasiWa;

class NotifikasiWaRepository
{
    public function getAll()
    {
        return NotifikasiWa::latest()->paginate(50);
    }

    public function create(array $data)
    {
        return NotifikasiWa::create($data);
    }

    public function updateStatus(int $id, string $status)
    {
        $notif = NotifikasiWa::findOrFail($id);
        $notif->update([
            'status' => $status,
            'sent_at' => now()
        ]);
        return $notif;
    }
}
