<?php

namespace Database\Seeders;

use App\Models\Position;
use Illuminate\Database\Seeder;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $positions = [
            [
                'position' => 'Department Manager',
                'salary'   => 10000
            ],
            [
                'position' => 'Assistant Manager',
                'salary'   => 5000
            ],
            [
                'position' => 'Chief Officer',
                'salary'   => 4500
            ],
            [
                'position' => 'Personal Staff',
                'salary'   => 4000
            ],
        ];

        foreach ($positions as $position) {
            Position::factory()->create([
                'position' => $position['position'],
                'salary'   => $position['salary'],
            ]);
        }
    }
}
