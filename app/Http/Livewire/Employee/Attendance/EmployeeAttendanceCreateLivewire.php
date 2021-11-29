<?php

namespace App\Http\Livewire\Employee\Attendance;

use App\Models\User;
use Livewire\Component;
use App\Models\Attendance;
use App\Rules\SameMonthYearRule;
use App\Models\EmployeeAttendance;
use App\Rules\NotYetPayrolledDateRule;
use App\Rules\UniqueAttendanceDateRule;

class EmployeeAttendanceCreateLivewire extends Component
{
    public $employee_id;

    public $attendance;
    public $description;
    public $start_date;
    public $end_date;

    function rules()
    {
        return [
            "attendance" => "required|exists:attendances,id",
            "description" => "max:240",
            'start_date' => [
                    'required',
                    'date_format:Y-m-d',
                    new UniqueAttendanceDateRule($this->employee_id),
                    new NotYetPayrolledDateRule($this->employee_id),
                ],
            'end_date' => [
                    'required',
                    'date_format:Y-m-d',
                    'after_or_equal:start_date',
                    new SameMonthYearRule($this->start_date),
                    new UniqueAttendanceDateRule($this->employee_id),
                    new NotYetPayrolledDateRule($this->employee_id),
                ],
        ];
    }

    public function mount($employee_id)
    {
        $this->employee_id = $employee_id;
    }

    public function reset_create()
    {
        $this->attendance = null;
        $this->description = null;
        $this->start_date = null;
        $this->end_date = null;
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function render()
    {
        return view('livewire.employee.attendance.employee-attendance-create-livewire', [
                'employee' => $this->get_employee(),
                'attendances' => $this->get_attendances(),
            ]);
    }

    protected function get_employee()
    {
        return User::where('id', $this->employee_id)->whereEmployee()->first();
    }

    protected function get_attendances()
    {
        return Attendance::orderBy('type')
            ->orderBy('attendance')
            ->get();
    }

    public function save()
    {
        $this->validate();

        $employee_attendance = new EmployeeAttendance;
        $employee_attendance->user_id       = $this->employee_id;
        $employee_attendance->attendance_id = $this->attendance;
        $employee_attendance->description   = $this->description;
        $employee_attendance->start_at      = $this->start_date;
        $employee_attendance->end_at        = $this->end_date;
    
        if ( $employee_attendance->save() ) {
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'success',  
                'message' => 'Employee Attendance/Leave Added', 
                'text' => 'Employee attendance/leave added successfully'
            ]);
            $this->emitUp('attendance', true, $employee_attendance->id);
            $this->reset_create();
            $this->dispatchBrowserEvent('employee-attendance-modal', ['action' => 'hide']);
        }
    }
}
