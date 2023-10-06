<?php

namespace Database\Seeders;

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
        $roles = ['Super admin' => 'manager', 'Supervisor' => 'Supervisor', 'Employee' => 'User','Admin' => 'admin'];

        foreach ($roles as $key => $value) {
            DB::table('roles')->insert(['name' => $key, 'guard_name' => $value]);
        }
    }
}
