<?php
namespace App\Repository;

use App\Models\Pelanggaran;
use App\Models\Siswa;
use DB;

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
            ->orderBy('total_poin', 'desc')
            ->having('total_poin', '>', 50)
            ->with('siswa:id,nama')
            ->get();
    }

    public function getCountSiswaWithPelanggaran()
    {
        $totalSiswa = Siswa::count();
        $siswaTerlanggar = Siswa::whereHas('pelanggaran')->count();
        ;
        $data = [
            'siswa_terlanggar' => $siswaTerlanggar,
            'total_siswa' => $totalSiswa
        ];
        return $data;
    }

    public function getCountPelanggaran()
    {
        return Pelanggaran::count();
    }

    public function getChartData()
    {
        return Pelanggaran::select(
            DB::raw('COUNT(*) as total'),
            DB::raw("DATE_FORMAT(tanggal, '%M') as month"),
            DB::raw("MONTH(tanggal) as month_num")
        )
            ->whereYear('tanggal', date('Y'))
            ->groupBy('month', 'month_num')
            ->orderBy('month_num')
            ->get();
    }
}