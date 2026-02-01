<?php

namespace App\Http\Controllers;

use App\Http\Requests\SiswaRequest;
use App\Http\Resources\SiswaResource;
use App\Models\Siswa;
use App\Services\SiswaService;
use Barryvdh\DomPDF\Facade\Pdf;


class SiswaController extends Controller
{
    public function __construct(protected SiswaService $siswaService)
    {
    }

    public function index()
    {
        $fields = ['id', 'nis', 'nama', 'kelas_id', 'nama_wali', 'no_hp_wali'];
        $siswa = $this->siswaService->getAll($fields ?? ['*']);
        return response()->json([
            'status' => 'success',
            'data' => SiswaResource::collection($siswa)
        ]);
    }

    public function show(int $siswaId)
    {
        try {
            $siswa = $this->siswaService->getById($siswaId);
            return response()->json([
                'status' => 'success',
                'data' => new SiswaResource($siswa)
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
            'data' => is_array($siswa) ? SiswaResource::collection($siswa) : new SiswaResource($siswa)
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
            ], 500);
        }
    }

    public function destroy(int $siswaId)
    {
        try {
            $siswa = $this->siswaService->delete($siswaId);
            return response()->json([
                'status' => 'success',
                'message' => 'Delete successfully'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to delete, ' . $th->getMessage()
            ]);
        }
    }


    public function exportPdf($id)
    {
        $siswa = Siswa::with(['pelanggaran.guru', 'pelanggaran.jenisPelanggaran', 'hasilSaw.tahap'])
            ->findOrFail($id);

        $pdf = Pdf::loadView('pdf.laporan_siswa', compact('siswa'))
            ->setPaper('a4', 'portrait');

        return $pdf->download("Laporan_Pelanggaran_{$siswa->nis}.pdf");
    }
}
