<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role = Role::updateOrCreate([
            'name' => 'Admin',
        ], [
            'description' => 'Admin role access',
        ]);

        $allPermissions = Permission::get();
        foreach ($allPermissions as $permission) {
            $role->permissions()->create([
                'permission_id' => $permission->id,
            ]);
        }

        $role = Role::updateOrCreate([
            'name' => 'Anggota',
        ], [
            'description' => 'Anggota Biasa role access',
        ]);

        $role = Role::updateOrCreate([
            'name' => 'Anggota Luar Biasa',
        ], [
            'description' => 'Anggota Luar Biasa role access',
        ]);

        $role = Role::updateOrCreate([
            'name' => 'Anggota Kehormatan',
        ], [
            'description' => 'Anggota Kehormatan role access',
        ]);
    }
}
