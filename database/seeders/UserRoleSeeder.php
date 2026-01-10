<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = ['admin', 'guru_bk', 'guru_piket'];
        $permissions = ['create role', 'edit role', 'delete role', 'view role'];

        foreach ($user as $users) {
            $role = Role::firstOrCreate(['name' => $users]);
        }

        foreach ($permissions as $havePermission) {
            $permission = Permission::firstOrCreate(['name' => $havePermission]);
        }

        $adminPermission = Role::where('name', 'admin')->first();
        $adminPermission->givePermissionTo($permissions);

        foreach ($user as $akunUser) {
            $akun = User::create([
                'name' => ucfirst($akunUser) . 'User',
                'email' => $akunUser . '@contoh.com',
                'password' => Hash::make(12345678)
            ]);

            $akun->assignRole($akunUser);
        }
    }
}
