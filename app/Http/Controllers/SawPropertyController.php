<?php

namespace App\Http\Controllers;

use App\Http\Resources\HasilSawResource;
use App\Http\Resources\RankingResource;
use App\Repository\SawRepository;
use FontLib\TrueType\Collection;
use Illuminate\Http\Request;

class SawPropertyController extends Controller
{
    public function __construct(protected SawRepository $sawRepo)
    {
    }

    public function indexTahap()
    {
        $tahap = $this->sawRepo->getAllTahap();
        return response()->json([
            'status' => 'success',
            'data' => $tahap
        ]);
    }

    public function showTahap(int $id)
    {
        $tahap = $this->sawRepo->getByIdTahap($id);
        return response()->json([
            'status' => 'success',
            'data' => $tahap
        ]);
    }

    public function storeTahap(Request $request)
    {
        $validate = $request->validate(
            [
                'tahap' => ['required', 'string', 'min:5'],
                'deskripsi' => ['required', 'string', 'min:5'],
            ]
        );

        $tahap = $this->sawRepo->storeTahap($validate);
        return response()->json([
            'success' => 'success',
            'data' => $tahap
        ]);
    }

    public function updateTahap(Request $request, int $id)
    {
        $validate = $request->validate(
            [
                'tahap' => ['nullable', 'string', 'min:5'],
                'deskripsi' => ['nullable', 'string', 'min:5'],
            ]
        );

        $tahap = $this->sawRepo->updateTahap($validate, $id);
        return response()->json([
            'status' => 'success',
            'data' => $tahap
        ]);
    }

    public function destroyTahap(int $id)
    {
        try {
            $tahap = $this->sawRepo->deleteTahap($id);
            return response()->json([
                'success' => 'success',
                'message' => 'Deleted successfully'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage()
            ]);
        }
    }

    public function indexKriteria()
    {
        $data = $this->sawRepo->getAllKriteria();
        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }

    public function storeKriteria(Request $request)
    {
        $validate = $request->validate([
            'nama' => ['required', 'string', 'min:3'],
        ]);

        $data = $this->sawRepo->storeKriteria($validate);
        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }

    public function showKriteria($id)
    {
        $data = $this->sawRepo->getByIdKriteria($id);
        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }

    public function updateKriteria(Request $request, int $id)
    {
        $validate = $request->validate([
            'nama' => ['nullable', 'string', 'min:3'],
        ]);
        try {
            $data = $this->sawRepo->updateKriteria($validate, $id);
            return response()->json([
                'status' => 'success',
                'data' => $data
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage()
            ]);
        }
    }

    public function destroyKriteria($id)
    {
        $this->sawRepo->deleteTahap($id);
        return response()->json([
            'status' => 'success',
            'message' => 'Delete successfully'
        ]);
    }

    public function indexHasilSaw()
    {
        $hasilSaw = $this->sawRepo->getAllHasilSaw();
        return response()->json([
            'status' => 'success',
            'data' => HasilSawResource::collection($hasilSaw)
        ]);
    }

    public function rankingSaw()
    {
        $ranking = $this->sawRepo->rankingSaw();
        return response()->json([
            'status' => 'success',
            'data' => ($ranking instanceof \Illuminate\Support\Collection) ?
                RankingResource::collection($ranking) :
                new RankingResource($ranking)
        ]);
    }

    // BobotRules CRUD Endpoints
    public function indexBobot()
    {
        $bobot = $this->sawRepo->getAllBobot();
        return response()->json([
            'status' => 'success',
            'data' => $bobot
        ]);
    }

    public function showBobot(int $id)
    {
        $bobot = $this->sawRepo->getByIdBobot($id);
        return response()->json([
            'status' => 'success',
            'data' => $bobot
        ]);
    }

    public function storeBobot(Request $request)
    {
        $validate = $request->validate([
            'tahap_id' => ['required', 'integer', 'exists:tahap,id'],
            'kriteria_id' => ['required', 'integer', 'exists:kriteria,id'],
            'bobot' => ['required', 'numeric', 'min:0.1', 'max:1.0'],
        ]);

        try {
            $bobot = $this->sawRepo->storeBobot($validate);
            return response()->json([
                'status' => 'success',
                'data' => $bobot
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage()
            ], 422);
        }
    }

    public function updateBobot(Request $request, int $id)
    {
        $validate = $request->validate([
            'bobot' => ['nullable', 'numeric', 'min:0.1', 'max:1.0'],
        ]);

        try {
            $bobot = $this->sawRepo->updateBobot($validate, $id);
            return response()->json([
                'status' => 'success',
                'data' => $bobot
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage()
            ], 422);
        }
    }

    public function destroyBobot(int $id)
    {
        try {
            $this->sawRepo->deleteBobot($id);
            return response()->json([
                'status' => 'success',
                'message' => 'Bobot deleted successfully'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage()
            ], 422);
        }
    }

}
