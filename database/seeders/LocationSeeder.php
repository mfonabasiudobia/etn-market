<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use DB;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */


    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        // DB::table('cities')->truncate();
        // DB::table('states')->truncate();
        // DB::table('countries')->truncate();
        $file_path = database_path('countries_state_city.sql');
        DB::unprepared(file_get_contents($file_path));
    }
}
