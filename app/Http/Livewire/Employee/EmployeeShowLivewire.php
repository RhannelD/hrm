<?php

namespace App\Http\Livewire\Employee;

use App\Models\User;
use Livewire\Component;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class EmployeeShowLivewire extends Component
{
    use AuthorizesRequests;
    
    public $employee_id;
    
    public function mount($employee_id)
    {
        $this->employee_id = $employee_id;
        $employee = $this->get_employee();

        abort_if(is_null($employee), '404');
        $this->authorize('view', $employee);
    }

    public function render()
    {
        return view('livewire.employee.employee-show-livewire', [
                'employee' => $this->get_employee(),
            ])
            ->extends('livewire.main.main');
    }

    public function get_employee()
    {
        return User::where('id', $this->employee_id)->whereEmployee()->first();
    }
}
