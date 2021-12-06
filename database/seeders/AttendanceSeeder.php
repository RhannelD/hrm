<?php

namespace Database\Seeders;

use App\Models\Attendance;
use Illuminate\Database\Seeder;

class AttendanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $attendances = [
            [
                'attendance' => 'Overtime',
                'payment' => 110,
                'description' => 'Staying behind to work after the office hours or regular shift for that day is finished.',
            ],
            [
                'attendance' => 'Late',
                'payment' => 95,
                'description' => 'Arriving at work later than is usual.',
            ],
            [
                'attendance' => 'Absent',
                'payment' => 0,
                'description' => 'Time taken off work by an employee.',
            ],
        ];

        foreach ($attendances as $attendance) {
            Attendance::factory()->create([
                'type'       => 'attendance',
                'attendance' => $attendance['attendance'],
                'payment'    => $attendance['payment'],
                'description'=> $attendance['description'],
            ]);
        }

        $leaves = [
            [
                'attendance' => 'Sick Leave',
                'payment' => 100,
                'description' => 'Sick Leave leave of absence granted because of illness.',
            ],
            [
                'attendance' => 'Casual Leave',
                'payment' => 100,
                'description' => 'These leave are granted for certain unforeseen situation or were you are require to go for one or two days leaves.',
            ],
            [
                'attendance' => 'Public Holliday',
                'payment' => 100,
                'description' => 'An official holiday when banks, schools, and many businesses are closed for the day.',
            ],
            [
                'attendance' => 'Maternity Leave',
                'payment' => 100,
                'description' => 'Maternity Leave a period of absence from work granted to a mother before and after the birth of her child.',
            ],
            [
                'attendance' => 'Paternity Leave',
                'payment' => 100,
                'description' => 'Paternity Leave a period of absence from work granted to a father after or shortly before the birth of his child.',
            ],
            [
                'attendance' => 'Unpaid Leave',
                'payment' => 0,
                'description' => 'Unpaid leave is the extended time period your employer allows you to take off of work without providing you with compensation during that time.',
            ],
            [
                'attendance' => 'Half Day Leave',
                'payment' => 50,
                'description' => 'These are permitted leave that allows the employee to leave the office for half of the normal working hours.',
            ],
        ];

        foreach ($leaves as $leave) {
            Attendance::factory()->create([
                'type'       => 'leave',
                'attendance' => $leave['attendance'],
                'payment'    => $leave['payment'],
                'description'=> $leave['description'],
            ]);
        }
    }
}
