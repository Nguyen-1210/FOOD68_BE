<?php

namespace Database\Seeders;

use App\Models\Dish;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DishSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
          [
            'name' => 'Bò sốt vang',
            'original_price' => 1000000,
          ],
          [
            'name' => 'Gà sốt cay',
            'original_price' => 200000,
          ],
          [
            'name' => 'Cá hồi sốt chanh',
            'original_price' => 300000,
          ],
        ];

        foreach ($data as $item) {
            Dish::create($item);
        }
    }
}