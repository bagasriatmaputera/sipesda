<?php

namespace App\Http\Controllers;

use App\Http\Requests\GuruRequest;
use App\Http\Resources\GuruResource;
use App\Services\GuruService;
use Illuminate\Http\Request;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class GuruController extends Controller
{
    protected $guruService;

    /**
     * Inject GuruService melalui constructor
     */
    public function __construct(GuruService $guruService)
    {
        $this->guruService = $guruService;
    }

    /**
     * Menampilkan daftar semua guru (dengan pagination)
     */
    public function index()
    {
        $gurus = $this->guruService->getAllGurus();

        return response()->json([
            'message' => 'Daftar guru berhasil diambil',
            'data' => GuruResource::collection($gurus)
        ], Response::HTTP_OK);
    }

    /**
     * Menyimpan data guru (mendukung single maupun bulk)
     */
    public function store(GuruRequest $request)
    {

        try {
            $data = $this->guruService->storeGuru($request->validated());

            $resource = ($data instanceof \Illuminate\Support\Collection || is_array($data))
                ? GuruResource::collection($data)
                : new GuruResource($data);

            return response()->json([
                'message' => 'Data guru berhasil disimpan',
                'data' => $resource
            ], Response::HTTP_CREATED);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Menampilkan detail satu guru
     */
    public function show(int $id)
    {
        try {
            $guru = $this->guruService->getGuruById($id);
            return response()->json([
                'data' => new GuruResource($guru)
            ], Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Guru tidak ditemukan'
            ], Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Memperbarui data guru
     */
    public function update(GuruRequest $request, int $id)
    {
        try {
            $guru = $this->guruService->updateGuru($id, $request->validated());

            return response()->json([
                'message' => 'Data guru berhasil diperbarui',
                'data' => new GuruResource($guru)
            ], Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Menghapus data guru
     */
    public function destroy(int $id)
    {
        try {
            $this->guruService->deleteGuru($id);

            return response()->json([
                'message' => 'Data guru berhasil dihapus'
            ], Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
