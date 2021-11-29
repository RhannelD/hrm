<?php

namespace App\Http\Livewire\Employee\Attendance;

use Livewire\Component;
use App\Models\EmployeeAttendance;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class EmployeeAttendanceShowLivewire extends Component
{
    use AuthorizesRequests;
    
    public $attendance_id;

    public function mount($attendance_id)
    {
        $this->attendance_id = $attendance_id;
        $employee_attendance = $this->get_employee_attendance();

        abort_if(is_null($employee_attendance), '404');
        $this->authorize('view', $employee_attendance);
    }

    public function render()
    {
        return view('livewire.employee.attendance.employee-attendance-show-livewire', [
                'employee_attendance' => $this->get_employee_attendance(),
            ])
            ->extends('livewire.main.main');
    }

    protected function get_employee_attendance()
    {
        return EmployeeAttendance::find($this->attendance_id);
    }
}
