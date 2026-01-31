<?php
namespace App\Repository;

use App\Models\Pelanggaran;
use App\Models\Siswa;

class DashboardRepository
{
    public function getTotalPelanggaraPerWeek()
    {
        $startOfWeek = now()->startOfWeek();
        $endOfWeek = now()->endOfWeek();
        return Pelanggaran::whereBetween('updated_at', [$startOfWeek, $endOfWeek])->count();
    }

    public function getSiswaMaxPoin()
    {
        return Pelanggaran::selectRaw('siswa_id, SUM(poin) as total_poin')
            ->groupBy('siswa_id')
            ->having('total_poin', '>', 50)
            ->with('siswa:id,nama')
            ->get();
    }

    public function getCountSiswaWithPelanggaran(){
        return Siswa::whereHas('pelanggaran')->count();
    }

    public function getCountPelanggaran(){
        return Pelanggaran::count();
    }
}