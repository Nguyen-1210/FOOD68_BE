<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = collect(
            [
                [
                    'name' => 'Quản lý',
                    'email' => 'admin@example.com',
                    'password' => bcrypt('password'),
                ],
                [
                    'name' => 'Thu ngân',
                    'email' => 'cashier@example.com',
                    'password' => bcrypt('password'),
                ],
                [
                    'name' => 'Bếp',
                    'email' => 'kitchen@example.com',
                    'password' => bcrypt('password'),
                ],
                [
                    'name' => 'Phục vụ',
                    'email' => 'serve@example.com',
                    'password' => bcrypt('password'),
                ],
            ]);

            $data->each(function ($item) {
                User::create($item);
            });
    }
}