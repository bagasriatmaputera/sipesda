<?php

namespace App\Http\Controllers;

use App\Http\Requests\JenisPelanggaranRequest;
use App\Http\Requests\PelanggaranRequest;
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

    public function showPelanggaran(Request $request)
    {
        $request->validate([
            'pelanggaran_id' => 'required|exists:pelanggaran,id'
        ]);
        try {
            $data = $this->pelanggaranService->getById($request['pelanggaran_id']);
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
        return DB::transaction(function () use ($request) {
            $poinAwal = InformasiPelanggaranSiswa::select(['id', 'poin_pelanggaran'])
                ->where('siswa_id', $request['siswa_id'])
                ->first();

            $besarPoin = JenisPelanggaran::select(['id', 'poin'])
                ->where('id', $request['jenis_pelanggaran_id'])->first();

            try {
                $data = $this->pelanggaranService->create($request->validated);

                $infoPelSis = InformasiPelanggaranSiswa::create([
                    'siswa_id' => $request['siswa_id'],
                    'poin_pelanggaran' => $poinAwal += $besarPoin->poin,
                    'tahap' => null
                ]);
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
        });
    }

    public function updatePelanggaran(int $id, PelanggaranRequest $request)
    {
        return DB::transaction(function () use ($id, $request) {
            $infoSiswa = InformasiPelanggaranSiswa::where('siswa_id', $request['siswa_id'])->first();

            $poinAwal = InformasiPelanggaranSiswa::select(['id', 'poin_pelanggaran'])
                ->where('siswa_id', $request['siswa_id'])
                ->first();

            $besarPoin = JenisPelanggaran::select(['id', 'poin'])
                ->where('id', $request['jenis_pelanggaran_id'])->first();

            try {
                $data = $this->pelanggaranService->update($id, $request->validated());
                $infoSiswa->update([
                    'poin_pelanggaran' => $poinAwal += $besarPoin->poin,
                ]);
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
        });
    }

    public function deletePelanggaran(int $id)
    {
        return DB::transaction(function () use ($id) {
            $pelanggaran = Pelanggaran::select(['id', 'siswa_id', 'poin'])->where('id', $id)->first();
            $infoSiswa = InformasiPelanggaranSiswa::where('siswa_id', $pelanggaran->siswa_id)->first();
            try {
                $data = $this->pelanggaranService->delete($id);

                $infoSiswa->update([
                    'poin_pelanggaran' => $infoSiswa->poin_pelanggaran -= $pelanggaran->poin,
                ]);
                return response()->json([
                    'status' => 'error',
                    'message' => 'Success delete data. '
                ]);
            } catch (\Throwable $th) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Failde to delete data. ' . $th->getMessage()
                ]);
            }
        });
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
        $fields = ['id', 'nama_pelanggaran', 'kategori'];
        $data = $this->repoJenisPelanggaran->getAll($fields);
        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }

    public function showJenisPelanggaran(Request $request)
    {
        $request->validate([
            'jenis_pelanggaran_id' => 'require|exists:jenis_pelanggaran,id'
        ]);

        try {
            $data = $this->repoJenisPelanggaran->getById($request['jenis_pelanggaran_id']);
            return response()->json([
                'status' => 'success',
                'data' => $data
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
