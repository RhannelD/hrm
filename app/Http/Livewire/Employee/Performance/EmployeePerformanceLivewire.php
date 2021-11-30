<?php

namespace App\Http\Livewire\Employee\Performance;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Payroll;
use Livewire\Component;
use App\Models\Attendance;
use App\Models\EmployeeAttendance;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class EmployeePerformanceLivewire extends Component
{
    use AuthorizesRequests;
    
    public $employee_id;

    public $date;

    protected $queryString = ['date'];

    public function mount($employee_id)
    {
        $this->employee_id = $employee_id;
    }

    public function render()
    {
        return view('livewire.employee.performance.employee-performance-livewire', [
                'payroll' => $this->get_payroll(),
                'employee' => $this->get_employee(),
                'attendances' => $this->get_attendances(),
                'leaves' => $this->get_leaves(),
                'salary_details' => $this->get_salary_details(),
            ])
            ->extends('livewire.main.main');
    }

    public function get_payroll()
    {
        $date = Carbon::parse($this->date);
        return Payroll::where('user_id', $this->employee_id)
            ->whereYear('payroll_at', '=', $date->format('Y'))
            ->whereMonth('payroll_at', '=', $date->format('m'))
            ->first();
    }

    protected function get_employee()
    {
        return User::where('id', $this->employee_id)->whereEmployee()->first();
    }

    protected function get_attendances()
    {
        $employee_id =  $this->employee_id;
        $date = Carbon::parse($this->date);
        return Attendance::whereAttendance()
            ->with([
                'employee_attendances' => function ($query) use ($employee_id, $date) {
                    $query->where('user_id', $employee_id)
                    ->whereYear('start_at', '=', $date->format('Y'))
                    ->whereMonth('start_at', '=', $date->format('m'));
                }
            ])
            ->whereHas('employee_attendances', function ($query) use ($employee_id, $date) {
                $query->where('user_id', $employee_id)
                ->whereYear('start_at', '=', $date->format('Y'))
                ->whereMonth('start_at', '=', $date->format('m'));
            })
            ->get();
    }

    protected function get_leaves()
    {
        $employee_id =  $this->employee_id;
        $date = Carbon::parse($this->date);
        return Attendance::whereLeave()
            ->with([
                'employee_attendances' => function ($query) use ($employee_id, $date) {
                    $query->where('user_id', $employee_id)
                    ->whereYear('start_at', '=', $date->format('Y'))
                    ->whereMonth('start_at', '=', $date->format('m'));
                }
            ])
            ->whereHas('employee_attendances', function ($query) use ($employee_id, $date) {
                $query->where('user_id', $employee_id)
                ->whereYear('start_at', '=', $date->format('Y'))
                ->whereMonth('start_at', '=', $date->format('m'));
            })
            ->get();
    }

    protected function get_salary_details()
    {
        $employee = $this->get_employee();

        $payroll = $this->get_payroll();
        $salary = isset($payroll)? $payroll->salary_per_day: $employee->employee_position->position->salary;

        $attendances = $this->get_attendances();
        $leaves = $this->get_leaves();

        $days = Carbon::parse($this->date)->daysInMonth;
        
        $attendance_salary = 0;
        foreach ($attendances as $attendance) {
            foreach ($attendance->employee_attendances as $employee_attendance) {
                $number_of_days = $employee_attendance->get_number_of_days();

                $days -= $number_of_days;
                $attendance_salary += $number_of_days*(($employee_attendance->attendance->payment*.01)*$salary);
            }
        }
        
        $leave_salary = 0;
        foreach ($leaves as $leave) {
            foreach ($leave->employee_attendances as $employee_attendance) {
                $number_of_days = $employee_attendance->get_number_of_days();

                $days -= $number_of_days;
                $leave_salary += $number_of_days*(($employee_attendance->attendance->payment*.01)*$salary);
            }
        }

        $normal_days_salary = $days*$salary;

        $total_salary = $normal_days_salary+$attendance_salary+$leave_salary;

        $details = [
            'daily_salary'      => $salary,
            'monthly_salary'    => $salary*(Carbon::parse($this->date)->daysInMonth),
            'normal_days_salary'=> $normal_days_salary,
            'attendance_salary' => $attendance_salary,
            'leave_salary'      => $leave_salary,
            'total_salary'      =>  isset($payroll)? $payroll->total_salary: $total_salary,
        ];

        return (object) $details;
    }

    protected function cant_payroll()
    {
        $employee = $this->get_employee();
        return $this->cant_payroll_by_date() || Auth::user()->cannot('create', [Payroll::class, $employee]) || $this->already_payrolled();
    }

    public function payroll_confirm()
    {
        if ( $this->cant_payroll() ) 
           return;
        
        $this->dispatchBrowserEvent('swal:confirm:payroll_confirm', [
            'type' => 'warning',  
            'message' => 'Employee Payroll', 
            'text' => 'Do you reall want to continue?',
        ]);
    }

    public function payroll()
    {
        if ( $this->cant_payroll() ) 
           return;
        
        $employee = $this->get_employee();
        $salary_details = $this->get_salary_details();

        $payroll = Payroll::create([
            'user_id'       => $employee->id,
            'department_id' => $employee->employee_position->department->id,
            'position_id'   => $employee->employee_position->position->id,
            'salary_per_day'=> $employee->employee_position->position->salary,
            'total_salary'  => $salary_details->total_salary,
            'payroll_at'    => Carbon::parse($this->date)->format('Y-m-d'),
        ]);

        if ( $payroll->wasRecentlyCreated ) {
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'success',  
                'message' => 'Payroll Success!', 
                'text' => "Success Payroll for {$employee->flname()}"
            ]);
        }
    }

    protected function cant_payroll_by_date()
    {
        $date_payroll = Carbon::parse($this->date)->format('m y');
        $date_now     = Carbon::now()->format('m y');

        if ( $date_payroll == $date_now ) {
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'warning',  
                'message' => 'Invalid Date', 
                'text' => "Payroll for this month is not yet available."
            ]);
            return true;
        }
        return false;
    }

    protected function already_payrolled()
    {
        $payroll = $this->get_payroll();

        if ( $payroll ) {
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'warning',  
                'message' => 'Already Payrolled', 
                'text' => ''
            ]);
            return true;
        }
        return false;
    }
}
