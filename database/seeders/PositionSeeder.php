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
                'position'    => 'Department Manager',
                'salary'      => 10000,
                'description' => 'Department Manager is responsible for all the functions of a sales department. They oversee the staff and implement strategies to increase productivity.',
            ],
            [
                'position'    => 'Assistant Manager',
                'salary'      => 5000,
                'description' => 'Assistant Manager is responsible for implementing workflow procedures based on direction from the company\'s Department Manager.',
            ],
            [
                'position'    => 'Chief Officer',
                'salary'      => 4500,
                'description' => 'Chief Officer monitors the day to day operation of a certain branch of the company.',
            ],
            [
                'position'    => 'Personal Staff',
                'salary'      => 4000,
                'description' => 'Personal Staff perform secretarial work and provide department managers with day-to-day administrative support.',
            ],
        ];

        foreach ($positions as $position) {
            Position::factory()->create([
                'position'    => $position['position'],
                'salary'      => $position['salary'],
                'description' => $position['description'],
            ]);
        }
    }
}
