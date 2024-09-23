<?php

namespace Database\Seeders;

use App\Models\Customers;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      Customers::create([
        'user_name' => 'HOANG',
        'phone' => '0836775904'
      ]);
    }
}