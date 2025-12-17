<?php

namespace App\Http\Controllers;

use App\Http\Requests\SiswaRequest;
use App\Services\SiswaService;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    public function __construct(protected SiswaService $siswaService) {}

    public function index()
    {
        $fields = ['nis', 'nama', 'kelas', 'total_poin'];
        $siswa = $this->siswaService->getAll($fields ?? ['*']);
        return response()->json([
            'status' => 'success',
            'data' => $siswa
        ]);
    }

    public function show(int $siswaId)
    {
        try {
            $siswa = $this->siswaService->getById($siswaId);
            return response()->json([
                'status' => 'success',
                'data' => $siswa
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'success',
                'message' => 'Failed load data, ' . $th->getMessage()
            ]);
        }
    }

    public function store(SiswaRequest $request)
    {
        $siswa = $this->siswaService->create($request->validated());
        return response()->json([
            'status' => 'success',
            'message' => 'Success create siswa'
        ]);
    }

    public function update(SiswaRequest $request, int $siswaId)
    {
        try {
            $siswa = $this->siswaService->update($siswaId, $request->validated());
            return response()->json([
                'status' => 'success',
                'data' => $siswa
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed update data, ' . $th->getMessage()
            ]);
        }
    }
}
