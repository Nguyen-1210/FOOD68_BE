<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingSystemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('setting_systems')->insert([
            'close_door' => '240000',
            'open_door' => '080000',
            'hour_table' => '030000',
        ]);
    }
}