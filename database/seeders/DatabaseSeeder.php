<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
          RoleSeeder::class,
          UserSeeder::class,
          CategorySeeder::class,
          DishSeeder::class,
          CategoryDishSeeder::class,
          FloorSeeder::class,
          TableSeeder::class,
          SettingSystemSeeder::class,
          CustomersSeeder::class,
          // TableOrderSeeder::class,
          // OrderSeeder::class,
          // OrderDetailSeeder::class,
        ]);
    }
}