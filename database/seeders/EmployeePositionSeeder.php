<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Position;
use App\Models\Department;
use Illuminate\Database\Seeder;
use App\Models\EmployeePosition;

class EmployeePositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $employees = User::whereEmployee()->get();
        $departments = Department::all();
        $positions =  Position::all();

        $employees_count = count($employees);
        $employee_index = 0;

        foreach ($positions as $position) {
            if ( $employee_index>=$employees_count ) 
                break;

            foreach ($departments as $department) {
                if ( $employee_index>=$employees_count ) 
                    break;

                EmployeePosition::factory()->create([   
                    'user_id' => $employees[$employee_index++]->id,
                    'department_id' => $department->id,
                    'position_id' => $position->id,
                ]);
            }
        }
    }
}
