<?php

namespace App\Http\Livewire\Employee\Attendance;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\EmployeeAttendance;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class EmployeeAttendanceLivewire extends Component
{
    use AuthorizesRequests;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    
    public $employee_id;
    
    public $search = '';
    public $row_num = 10;
    
    protected $listeners = [
        'refresh'   => '$refresh',
        'attendance' => 'attendance',
    ];

    public function mount($employee_id)
    {
        $this->employee_id = $employee_id;
        $employee = $this->get_employee();

        abort_if(is_null($employee), '404');
        $this->authorize('view', $employee);
    }

    public function render()
    {
        return view('livewire.employee.attendance.employee-attendance-livewire', [
                'employee' => $this->get_employee(),
                'attendances' => $this->get_attendances(),
            ])
            ->extends('livewire.main.main');
    }
    
    protected function get_employee()
    {
        return User::where('id', $this->employee_id)->whereEmployee()->first();
    }

    protected function get_attendances()
    {
        $search =  trim($this->search);
        return EmployeeAttendance::where('user_id', $this->employee_id)
            ->when( isset($search), function ($query) use ($search) {
                    $query->whereHas('attendance', function ($query) use ($search) {
                        $query->where('attendance', 'like', "%{$search}%");
                    });
                })
            ->orderBy('start_at', 'DESC')
            ->paginate($this->row_num);
    }
    
    public function attendance($created, $employee_attendance_id)
    {
        if ($created) 
            return session()->flash("employee_attendance-{$employee_attendance_id}", 'table-success');
        return session()->flash("employee_attendance-{$employee_attendance_id}", 'table-info');
    }
    
    protected function get_employee_attendance($employee_attendance_id)
    {
        return EmployeeAttendance::find($employee_attendance_id);
    }

    public function delete_confirm($employee_attendance_id)
    {
        if ( Auth::guest() || Auth::user()->cannot('delete', $this->get_employee_attendance($employee_attendance_id)) ) 
            return;
        
        $this->dispatchBrowserEvent('swal:confirm:delete_employee_attendance', [
            'type' => 'warning',  
            'message' => 'Are you sure?', 
            'text' => 'If deleted, you will not be able to recover this employee!',
            'employee_attendance_id' => $employee_attendance_id,
        ]);
    }

    public function delete_employee_attendance($delete_employee_attendance_id)
    {
        $employee_attendance = $this->get_employee_attendance($delete_employee_attendance_id);
        if ( Auth::guest() || Auth::user()->cannot('delete', $employee_attendance) ) 
            return;

        if ( $employee_attendance->delete() ) {
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'success',
                'message' => 'Attendance Deleted', 
                'text' => 'Employee Attendance has been successfully deleted'
            ]);
        }
    }
}
