<?php

namespace App\Http\Livewire\Department;

use Livewire\Component;
use App\Models\Department;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class DepartmentShowLivewire extends Component
{
    use AuthorizesRequests;
    
    public $department_id;

    public function mount($department_id)
    {
        $this->department_id = $department_id;
        $department = $this->get_department();

        abort_if(is_null($department), '404');
        $this->authorize('view', $department);
    }

    public function render()
    {
        return view('livewire.department.department-show-livewire', [
                'department' => $this->get_department(),
            ])
            ->extends('livewire.main.main');
    }

    protected function get_department()
    {
        return Department::find($this->department_id);
    }
}
