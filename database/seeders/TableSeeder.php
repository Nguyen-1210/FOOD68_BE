<?php

namespace Database\Seeders;

use App\Models\Table;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
          [
            'name' => 'Bàn 1',
            'floor_id' => 1,
          ],
          [
            'name' => 'Bàn 2',
            'floor_id' => 1,
          ],
          [
            'name' => 'Bàn 3',
            'floor_id' => 1,
          ],
          [
            'name' => 'Bàn 4',
            'floor_id' => 1,
          ],
          [
            'name' => 'Bàn 5',
            'floor_id' => 1,
          ],
          [
            'name' => 'Bàn 6',
            'floor_id' => 1,
          ],
          [
            'name' => 'Bàn 7',
            'floor_id' => 1,
          ],
          [
            'name' => 'Bàn 8',
            'floor_id' => 1,
          ],
          [
            'name' => 'Bàn 9',
            'floor_id' => 1,
          ],
          [
            'name' => 'Bàn 10',
            'floor_id' => 1,
          ],
          [
            'name' => 'Bàn 11',
            'floor_id' => 2,
          ],
          [
            'name' => 'Bàn 12',
            'floor_id' => 2,
          ],
          [
            'name' => 'Bàn 13',
            'floor_id' => 2,
          ],
          [
            'name' => 'Bàn 14',
            'floor_id' => 2,
          ],
          [
            'name' => 'Bàn 15',
            'floor_id' => 2,
          ],
          [
            'name' => 'Bàn 16',
            'floor_id' => 2,
          ],
          [
            'name' => 'Bàn 17',
            'floor_id' => 2,
          ],
          [
            'name' => 'Bàn 18',
            'floor_id' => 2,
          ],
          [
            'name' => 'Bàn 19',
            'floor_id' => 2,
          ],
          [
            'name' => 'Bàn 20',
            'floor_id' => 2,
          ],
        ];

        foreach ($data as $item) {
            Table::create($item);
        }
    }
}