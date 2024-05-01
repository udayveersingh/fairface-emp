<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::where('name', '=', 'Super admin')->first();
        $users = User::where('role_id', '=', $role->id)->first();
        if (!empty($users)) {
            $user = User::find($users->id);
        } else {
            $user = new User();
        }
        $user->name = "John Doe";
        $user->username = 'admin';
        $user->email  = "admin@admin.com";
        $user->password = Hash::make('admin');
        $user->role_id = $role->id;
        $user->save();
    }
}
