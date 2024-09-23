<?php

namespace Database\Seeders;

use App\Models\DishOrder;
use App\Models\Order;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      Order::create([
            'table_order_id' => 1,
          ]);
    }
}