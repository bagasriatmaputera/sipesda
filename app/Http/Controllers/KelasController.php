<?php

namespace App\Http\Controllers;

use App\Http\Requests\KelasRequest;
use App\Services\KelasService;
use App\Http\Resources\KelasResource;
use Exception;
use Symfony\Component\HttpFoundation\Response;

class KelasController extends Controller
{
    protected $kelasService;

    public function __construct(KelasService $kelasService)
    {
        $this->kelasService = $kelasService;
    }

    public function index()
    {
        $data = $this->kelasService->getAllKelas();
        return response()->json([
            'message' => 'Data kelas berhasil diambil',
            'data' => KelasResource::collection($data)
        ], Response::HTTP_OK);
    }

    public function store(KelasRequest $request)
    {
        try {
            $data = $this->kelasService->storeKelas($request->validated());

            $resource = ($data instanceof \Illuminate\Support\Collection || isset($data[0]))
                ? KelasResource::collection($data)
                : new KelasResource($data);

            return response()->json([
                'message' => 'Data kelas berhasil disimpan',
                'data' => $resource
            ], Response::HTTP_CREATED);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show(int $id)
    {
        $kelas = $this->kelasService->getKelasById($id);
        return new KelasResource($kelas);
    }

    public function update(KelasRequest $request, int $id)
    {
        try {
            $data = $this->kelasService->updateKelas($id, $request->validated());
            return response()->json([
                'message' => 'Data kelas berhasil diperbarui',
                'data' => new KelasResource($data)
            ], Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function destroy(int $id)
    {
        try {
            $this->kelasService->deleteKelas($id);
            return response()->json(['message' => 'Kelas berhasil dihapus'], Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
