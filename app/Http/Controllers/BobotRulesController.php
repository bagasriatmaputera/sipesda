<?php

namespace App\Http\Controllers;

use App\Http\Resources\BobotRuleResoruce;
use App\Services\BobotRulesService;
use Illuminate\Http\Request;

class BobotRulesController extends Controller
{
    public function __construct(protected BobotRulesService $bobotService)
    {
    }
    //
    public function index()
    {
        $rules = $this->bobotService->getAll();
        return response()->json([
            'status' => 'success',
            'data' => BobotRuleResoruce::collection($rules)
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'tahap_id' => 'required|exists:tahaps,id',
            'kriteria_id' => 'required|exists:kriteria,id',
            'bobot' => 'required|numeric|between:0,1',
        ]);
        try {
            $rule = $this->bobotService->create($request->all());
            return response()->json([
                'status' => 'success',
                'data' => BobotRuleResoruce::collection($rule)
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal tambah data, ' . $th->getMessage()
            ]);
        }

    }

    public function show($id)
    {
        $rules = $this->bobotService->getById($id);
        return response()->json([
            'status' => 'success',
            'data' => BobotRuleResoruce::collection($rules)
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tahap_id' => 'prohibited',
            'kriteria_id' => 'prohibited',
            'bobot' => 'required|numeric|between:0,1',
        ]);
        try {
            //code...
            $rule = $this->bobotService->update($id, $request->all());
            return response()->json([
                'status' => 'success',
                'data' => $rule
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal update data, ' . $th->getMessage()
            ]);
        }
    }

    public function destroy($id)
    {
        $this->bobotService->delete($id);
        return response()->json([
            'status' => 'success',
            'message' => 'Delete successfully'
        ]);
    }
}
