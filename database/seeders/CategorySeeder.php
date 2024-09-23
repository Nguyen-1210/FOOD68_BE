<?php

namespace Database\Seeders;

use App\Models\Categories;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      $data = [
        [
        'name' => 'Cá',
        'active' => 0,
        'type' => 0,
        ],
        [
        'name' => 'Gà',
        'active' => 0,
        'type' => 0,
        ],
        [
        'name' => 'Thị heo',
        'active' => 0,
        'type' => 0,
        ],
        [
        'name' => 'Thịt bò',
        'active' => 0,
        'type' => 0,
        ],
        [
        'name' => 'Bánh trứng',
        'active' => 0,
        'type' => 1,
        ],
        [
        'name' => 'Xoài',
        'active' => 0,
        'type' => 2,
        ],
      ];

      foreach ($data as $item) {
        Categories::create($item);
      }
    }
}