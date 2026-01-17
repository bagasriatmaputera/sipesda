<?php

namespace App\Http\Controllers;

use App\Http\Requests\JenisPelanggaranRequest;
use App\Http\Requests\PelanggaranRequest;
use App\Http\Resources\JenisPelanggaranResource;
use App\Http\Resources\PelanggaranResource;
use App\Models\InformasiPelanggaranSiswa;
use App\Models\JenisPelanggaran;
use App\Models\Pelanggaran;
use App\Services\InformasiPelanggaranSiswaService;
use App\Services\JenisPelanggaranService;
use App\Services\PelanggaranService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PelanggaranController extends Controller
{
    public function __construct(
        protected PelanggaranService $pelanggaranService,
        protected JenisPelanggaranService $repoJenisPelanggaran,
        protected InformasiPelanggaranSiswaService $repoInformasi
    ) {}

    public function indexPelanggaran()
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

    public function showPelanggaran(int $id)
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

    public function storePelanggaran(PelanggaranRequest $request)
    {

        try {
            $data = $this->pelanggaranService->create($request->validated());
            return response()->json([
                'status' => 'success',
                'data' => is_array($data)
                    ? PelanggaranResource::collection(collect($data))
                    : new PelanggaranResource($data)
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failde to create data. ' . $th->getMessage()
            ]);
        }
    }

    public function updatePelanggaran(int $id, PelanggaranRequest $request)
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
                'message' => 'Error Controller ' . $th->getMessage()
            ]);
        }
    }

    public function deletePelanggaran(int $id)
    {
        try {
            $data = $this->pelanggaranService->delete($id);
            return response()->json([
                'status' => 'Success',
                'message' => 'Success delete data. '
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failde to delete data. ' . $th->getMessage()
            ]);
        }
    }

    public function getBySiswa(Request $request)
    {
        try {
            $request->validate([
                'siswa_id' => 'requeired|exist:siswa,id'
            ]);
            $data = $this->pelanggaranService->getBySiswa($request->validated());
            return response()->json([
                'status' => 'success',
                'data' => new PelanggaranResource($data)
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to load data. ' . $th->getMessage()
            ]);
        }
    }

    public function indexJenisPelanggaran()
    {
        $data = $this->repoJenisPelanggaran->getAll(['*']);
        return response()->json([
            'status' => 'success',
            'data' => JenisPelanggaranResource::collection($data)
        ]);
    }

    public function showJenisPelanggaran(int $id)
    {
        try {
            $data = $this->repoJenisPelanggaran->getById($id);
            return response()->json([
                'status' => 'success',
                'data' => new JenisPelanggaranResource($data)
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed load data, ' . $th->getMessage()
            ]);
        }
    }

    public function storeJenisPelanggaran(JenisPelanggaranRequest $request)
    {
        $data = $this->repoJenisPelanggaran->create($request->validated());
        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }

    public function updateJenisPelanggaran(JenisPelanggaranRequest $request, $id)
    {
        try {
            $data = $this->repoJenisPelanggaran->update($id, $request->validated());
            return response()->json([
                'status' => 'success',
                'data' => $data
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create data, ' . $th->getMessage()
            ]);
        }
    }

    public function deleteJenisPelanggaran(int $id)
    {
        $data = $this->repoJenisPelanggaran->delete($id);
        return response()->json([
            'status' => 'success',
            'messsage' => 'Delete success.'
        ]);
    }
}
