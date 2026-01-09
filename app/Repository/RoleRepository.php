<?php

namespace App\Repository;

use Spatie\Permission\Models\Role;

class RoleRepository
{
    public function getAll()
    {
        return Role::select('id', 'name')->get();
    }
    public function create($data)
    {
        return Role::create([
            'name' => $data['name'],
            'guard_name' => 'web'
        ]);
    }
    public function update(int $id, $data)
    {
        $role = Role::findOrFail($id);
        $role->update($data);
        return $role;
    }
    public function delete(int $id)
    {
        $role = Role::findOrFail($id);
        return $role->delete();
    }
}
