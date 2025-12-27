<?php

namespace App\Http\Controllers;

use App\Http\Requests\PelanggaranRequest;
use App\Http\Resources\InformasiPelanggaranResource;
use App\Services\InformasiPelanggaranSiswaService;
use Illuminate\Http\Request;

class InformasiPelanggaranSiswaController extends Controller
{
    public function __construct(protected InformasiPelanggaranSiswaService $repo) {}

    public function index()
    {
        $data = $this->repo->getAll();
        return response()->json([
            'status' => 'success',
            'data' => InformasiPelanggaranResource::collection($data)
        ]);
    }

    public function show(int $id)
    {
        try {
            $data = $this->repo->getById($id);
            return response()->json([
                'status' => 'success',
                'data' => new InformasiPelanggaranResource($data)
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed load data, ' . $th->getMessage()
            ]);
        }
    }

    public function getBySiswa(Request $request)
    {
        $validate = $request->validate([
            'name' => ['required', 'string', 'min:3']
        ]);
        try {
            $siswa = $this->repo->getBySiswa($validate['name']);
            return response()->json([
                'status' => 'success',
                'data' => new InformasiPelanggaranResource($siswa)
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed load data, ' . $th->getMessage()
            ]);
        }
    }

    public function getByKelas(Request $request)
    {
        $request->validate([
            'kelas_id' => ['required', 'numeric', 'exists:kelas,id']
        ]);

        try {
            $kelas = $this->repo->getByKelas($request['kelas_id']);
            return response()->json([
                'status' => 'success',
                'data' => new InformasiPelanggaranResource($kelas)
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed load data, ' . $th->getMessage()
            ]);
        }
    }

}
