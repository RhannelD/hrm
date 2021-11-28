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
            ],
            [
                'attendance' => 'Late',
                'payment' => 95,
            ],
            [
                'attendance' => 'Absent',
                'payment' => 0,
            ],
        ];

        foreach ($attendances as $attendance) {
            Attendance::factory()->create([
                'type'       => 'attendance',
                'attendance' => $attendance['attendance'],
                'payment'    => $attendance['payment'],
            ]);
        }

        $leaves = [
            [
                'attendance' => 'Sick Leave',
                'payment' => 100,
            ],
            [
                'attendance' => 'Casual Leave',
                'payment' => 100,
            ],
            [
                'attendance' => 'Public Holliday',
                'payment' => 100,
            ],
            [
                'attendance' => 'Maternity Leave',
                'payment' => 100,
            ],
            [
                'attendance' => 'Paternity Leave',
                'payment' => 100,
            ],
            [
                'attendance' => 'Unpaid Leave',
                'payment' => 0,
            ],
            [
                'attendance' => 'Half Day Leave',
                'payment' => 50,
            ],
        ];

        foreach ($leaves as $leave) {
            Attendance::factory()->create([
                'type'       => 'leave',
                'attendance' => $leave['attendance'],
                'payment'    => $leave['payment'],
            ]);
        }
    }
}
