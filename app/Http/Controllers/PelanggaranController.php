<?php

namespace App\Http\Controllers;

use App\Http\Requests\PelanggaranRequest;
use App\Http\Resources\PelanggaranResource;
use App\Services\PelanggaranService;
use Illuminate\Http\Request;

class PelanggaranController extends Controller
{
    public function __construct(protected PelanggaranService $pelanggaranService) {}

    public function index()
    {
        $fields = [
            'siswa_id',
            'guru_id',
            'jenis_pelanggaran_id',
            'tanggal',
            'poin',
            'keterangan'
        ];
        $data = $this->pelanggaranService->getAll($fields ?? ['*']);
        return response()->json([
            'status' => 'success',
            'data' => PelanggaranResource::collection($data)
        ]);
    }

    public function show(int $id)
    {
        try {
            $data = $this->pelanggaranService->getById($id);
            return response()->json([
                'status' => 'success',
                'data' =>  new PelanggaranResource($data)
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failde to load data. ' . $th->getMessage()
            ]);
        }
    }

    public function store(PelanggaranRequest $request)
    {
        try {
            $data = $this->pelanggaranService->create($request->validated);
            return response()->json([
                'status' => 'success',
                'data' => PelanggaranResource::collection($data)
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failde to create data. ' . $th->getMessage()
            ]);
        }
    }

    public function update(int $id, PelanggaranRequest $request)
    {
        try {
            $data = $this->pelanggaranService->update($id, $request->validated());
            return response()->json([
                'status' => 'success',
                'data' =>  new PelanggaranResource($data)
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failde to update data. ' . $th->getMessage()
            ]);
        }
    }
}
