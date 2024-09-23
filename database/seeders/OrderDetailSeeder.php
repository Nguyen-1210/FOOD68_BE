<?php

namespace Database\Seeders;

use App\Models\OrderDetail;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      OrderDetail::create(
          [
            'order_id' => 1,
            'dish_id' => 1, 
            'price' => 50000,
            'quantity' => 1,
            'note' => 'Không ớt',
            'status' => 1
          ]);
    }
}