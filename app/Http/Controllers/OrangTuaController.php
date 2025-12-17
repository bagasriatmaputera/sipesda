<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrangTuaRequest;
use App\Http\Resources\OrangTuaResource;
use App\Services\OrangTuaService;
use Illuminate\Http\Request;

class OrangTuaController extends Controller
{
    public function __construct(protected OrangTuaService $orangTuaService) {}

    public function index()
    {
        $fields = ['*'];
        $parent = $this->orangTuaService->getAll($fields);
        return response()->json([
            'status' => 'success',
            'data' => OrangTuaResource::collection($parent)
        ]);
    }

    public function show(int $ortuId)
    {
        try {
            $parent = $this->orangTuaService->getById($ortuId);
            return response()->json([
                'status' => 'success',
                'data' => new OrangTuaResource($parent)
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed load data, ' . $th->getMessage()
            ]);
        }
    }

    public function store(OrangTuaRequest $request)
    {
        $data = $this->orangTuaService->create($request->validated());
        return response()->json([
            'status' => 'success',
            'data' => new OrangTuaResource($data)
        ]);
    }

    public function update(int $parentId, OrangTuaRequest $request)
    {
        $data = $this->orangTuaService->update($parentId, $request->validated());
        return response()->json([
            'status' => 'success',
            'data' => new OrangTuaResource($data)
        ]);
    }

    public function destroy(int $parentId)
    {
        $data = $this->orangTuaService->delete($parentId);
        return response()->json([
            'status' => 'success',
            'message' => 'Deleted successfully'
        ]);
    }

    public function getBySiswa(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswas,id'
        ]);

        $data = $this->orangTuaService->getBySiswa($request->siswa_id);

        if (!$data) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => new OrangTuaResource($data)
        ]);
    }
}
