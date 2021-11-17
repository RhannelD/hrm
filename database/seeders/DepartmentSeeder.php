<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $departments = [
            'Production Department',
            'Finance and Accounting Department',
            'Operation Department',
            'Research and Development Department',
            'Marketing Department',
            'Information Department',
            'Purchasing Department',
        ];

        foreach ($departments as $department) {
            Department::factory()->create([
                'department' => $department,
            ]);
        }
    }
}
