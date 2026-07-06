<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            ['name' => 'getUsers', 'group' => 'users'],
            ['name' => 'createUsers', 'group' => 'users'],
            ['name' => 'editUsers', 'group' => 'users'],
            ['name' => 'deleteUsers', 'group' => 'users'],
            ['name' => 'viewRoles', 'group' => 'roles'],
            ['name' => 'createRoles', 'group' => 'roles'],
            ['name' => 'editRoles', 'group' => 'roles'],
            ['name' => 'deleteRoles', 'group' => 'roles'],
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission['name']], ['group' => $permission['group']]);
        }
    }
}
