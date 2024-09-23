<?php

namespace Database\Seeders;

use App\Models\Floor;
use Illuminate\Database\Seeder;

class FloorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => 'Tầng 1',
                'ordering' => 1,
            ],
            [
                'name' => 'Tầng 2',
                'ordering' => 2,
            ],
        ];
        
        foreach ($data as $item) {
            Floor::create($item);
        }
    }
}