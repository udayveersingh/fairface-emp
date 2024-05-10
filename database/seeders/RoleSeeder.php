<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = ['Super admin' => 'manager', 'Employee' => 'User', 'Admin' => 'admin'];

        foreach ($roles as $key => $value) {

            $CheckRole = Role::where('name', '=', $key)->where('guard_name', '=', $value)->first();

            if (!empty($CheckRole)) {
                $role = Role::find($CheckRole->id);
            } else {
                $role = new Role();
            }
            $role->name = $key;
            $role->guard_name = $value;
            $role->save();
        }
    }
}
