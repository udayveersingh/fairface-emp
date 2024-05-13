<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
            RoleSeeder::class,
            CountrySeeder::class,
            UserSeeder::class,
            TimesheetStatusSeeder::class,
            HolidaysSeeder::class,
            JobTitleSeeder::class,
            CompanyDocumentSeeder::class
        ]);
    }
}
