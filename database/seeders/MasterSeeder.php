<?php

namespace Database\Seeders;

use App\Models\Master;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class MasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'user_id' => 6,
                'name'  => 'luke will',
                'email' => 'lukewill@gmail.com',
                'username' => 'luke will',
                'password' => Hash::make('luke123'),
                'sub_domain' => 'https://emp.ukvics.com',
            ],

            [
                'user_id' => 4,
                'name'  => 'Shams Tabrez',
                'email' => 'shams.tabrez6127@gmail.com',
                'username' => 'Shams Tabrez',
                'password' => Hash::make('shams123'),
                'sub_domain' => 'https://realresources.ukvics.com/',
            ],

            [
                'user_id' => 5,
                'name'  => 'Dilpreet Singh',
                'email' => 'dilpreetsingh19984@gmail.com',
                'username' => 'Dilpreet Singh',
                'password' => Hash::make('Singh05'),
                'sub_domain' => 'https://rjsoftwaresolutions.ukvics.com',
            ]

        ];
        foreach ($users as $value) {
            $masters = Master::where('user_id', '=', $value['user_id'])->where('sub_domain', '=', $value['sub_domain'])->first();
            if (!empty($masters)) {
                $master = Master::find($masters->id);
            } else {
                $master = new Master();
            }
            $master->user_id = $value['user_id'];
            $master->name = $value['name'];
            $master->email = $value['email'];
            $master->username = $value['username'];
            $master->password = $value['password'];
            $master->sub_domain = $value['sub_domain'];
            $master->save();
        }
    }
}
