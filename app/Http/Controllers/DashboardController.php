<?php

namespace App\Http\Controllers;

use App\Repository\DashboardRepository;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct(protected DashboardRepository $repo)
    {
    }
    public function countPelanggaran()
    {
        $data = $this->repo->getCountPelanggaran();
        return response()->json([
            'status' => 'success',
            'data' => $data,
        ]);
    }

    public function countSiswaWithPelanggaran()
    {
        $data = $this->repo->getCountSiswaWithPelanggaran();
        return response()->json([
            'status' => 'success',
            'data' => $data,
        ]);
    }

    public function getSiswaWith50Poin()
    {
        $data = $this->repo->getSiswaMaxPoin();
        return response()->json([
            'status' => 'success',
            'data' => $data,
        ]);
    }

    public function pelanggaranPerWeek()
    {
        $data = $this->repo->getTotalPelanggaraPerWeek();
        return response()->json([
            'status' => 'success',
            'data' => $data,
        ]);
    }
}
