<?php

namespace App\Http\Controllers;

use App\Services\RoleService;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function __construct(protected RoleService $roleService) {}

    public function index()
    {
        $data = $this->roleService->getAll();
        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string']
        ]);

        try {
            $data = $this->roleService->create($request->all());
            return response()->json([
                'status' => 'success',
                'data' => $data
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed, ' . $th->getMessage()
            ]);
        }
    }

    public function update(Request $request, int $id)
    {
        $request->validate([
            'name' => ['required', 'string']
        ]);

        try {
            $data = $this->roleService->update($id, $request->all());
            return response()->json([
                'status' => 'success',
                'data' => $data
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed, ' . $th->getMessage()
            ]);
        }
    }

    public function destroy(int $id)
    {
        try {
            $data = $this->roleService->delete($id);
            return response()->json([
                'status' => 'success',
                'message' => 'Delete successfully'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed, ' . $th->getMessage()
            ]);
        }
    }
}
