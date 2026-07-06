<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = ['admin', 'user', 'doctor'];

        foreach ($roles as $role) {
            role::firstOrCreate(['name' => $role]);
        }

        $adminRole = role::where('name', 'admin')->first();
        $permissionIds = Permission::pluck('id')->all();

        if ($adminRole && !empty($permissionIds)) {
            $adminRole->permissions()->syncWithoutDetaching($permissionIds);
        }
    }
}
