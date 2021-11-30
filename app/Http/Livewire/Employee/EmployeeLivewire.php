<?php

namespace App\Http\Livewire\Employee;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\EmployeePosition;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class EmployeeLivewire extends Component
{
    use AuthorizesRequests;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    
    public $search = '';
    public $row_num = 10;

    protected $listeners = [
        'refresh'   => '$refresh',
        'employee' => 'employee',
    ];

    public function mount()
    {
        $this->authorize('viewAny', [EmployeePosition::class]);
    }

    public function hydrate()
    {
        if ( Auth::guest() || Auth::user()->cannot('viewAny', [EmployeePosition::class]) ) {
            return redirect()->route('employee');
        }
    }

    public function render()
    {
        return view('livewire.employee.employee-livewire', [
                'employees' => $this->get_employees(),
            ])
            ->extends('livewire.main.main');
    }

    protected function get_employees()
    {
        return User::whereEmployee()
            ->with([
                'employee_position' => function ($query) {
                    $query->with(['position', 'department']);
                }
            ])
            ->whereSearch($this->search)
            ->when(!Auth::user()->is_admin() && Auth::user()->can_payroll(), function ($query) {
                $query->whereHas('employee_position', function ($query) {
                    $query->where('department_id', Auth::user()->employee_position->department_id);
                });
            })
            ->when(!Auth::user()->is_admin() && !Auth::user()->can_payroll(), function ($query) {
                $query->where('id', Auth::id());
            })
            ->paginate($this->row_num);
    }
    
    public function employee($created, $user_id)
    {
        if ($created) 
            return session()->flash("user-{$user_id}", 'table-success');
        return session()->flash("user-{$user_id}", 'table-info');
    }

    protected function get_user($user_id)
    {
        return User::find($user_id);
    }

    public function delete_confirm($user_id)
    {
        if ( Auth::guest() || Auth::user()->cannot('delete', $this->get_user($user_id)) ) 
            return;
        
        $this->dispatchBrowserEvent('swal:confirm:delete_user', [
            'type' => 'warning',  
            'message' => 'Are you sure?', 
            'text' => 'If deleted, you will not be able to recover this employee!',
            'user_id' => $user_id,
        ]);
    }

    public function delete_user($user_id)
    {
        $user = $this->get_user($user_id);
        if ( Auth::guest() || Auth::user()->cannot('delete', $user) ) 
            return;

        if ( $user->delete() ) {
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'success',
                'message' => 'Employee Deleted', 
                'text' => 'Employee has been successfully deleted'
            ]);
        }
    }
}
