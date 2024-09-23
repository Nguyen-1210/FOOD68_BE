<?php

namespace Database\Seeders;

use App\Models\TableOrder;
use Illuminate\Database\Seeder;

class TableOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TableOrder::create(
            [
              'order_date' => '2024-07-24 18:00:00',
              'table_id' => 1,
              'customer_id' => 1,
            ],
        );
    }
}