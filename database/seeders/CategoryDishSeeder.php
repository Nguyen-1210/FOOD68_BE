<?php

namespace Database\Seeders;

use App\Models\CategoryDish;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoryDishSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
          ['category_id' => 4, 'dish_id' => 1],
          ['category_id' => 2, 'dish_id' => 2],
          ['category_id' => 3, 'dish_id' => 3],
        ];
        
        foreach ($data as $item) {
            CategoryDish::insert($item);
        }
    }
}