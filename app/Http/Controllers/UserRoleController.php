<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRoleRequest;
use App\Services\UserAssignRoleService;
use Illuminate\Http\Request;

class UserRoleController extends Controller
{
    public function __construct(protected UserAssignRoleService $service) {}
    public function assignRole(UserRoleRequest $request)
    {
        $data = $this->service->assignRoleToUser(
            $request->validated()['user_id'],
            $request->validated()['role_id']
        );
        return response()->json([
            'message' => 'success assigned role',
            'data' => $data
        ]);
    }

    public function removeRole(UserRoleRequest $request)
    {
        $data = $this->service->removeRoleUser(
            $request->validated()['user_id'],
            $request->validated()['role_id']
        );
        return response()->json([
            'message' => 'remove role successfully',
            'data' => $data
        ]);
    }

    public function listRoleUser(int $userId)
    {
        try {
            $role = $this->service->getRoleUser($userId);
            return response()->json([
                'status' => 'success',
                'data' => $role
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed load data, ' . $th->getMessage()
            ]);
        }
    }
}
