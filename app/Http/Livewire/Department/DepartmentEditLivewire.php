<?php

namespace App\Http\Livewire\Department;

use Livewire\Component;
use App\Models\Department;
use Illuminate\Support\Facades\Auth;

class DepartmentEditLivewire extends Component
{
    public $department_id;

    public $department;

    function rules()
    {
        return [
            "department.department" => "required|min:3|max:180|unique:departments,department".(isset($this->department_id)? ",{$this->department_id}": ""),
            "department.description" => "max:65000",
        ];
    }

    public function mount()
    {
        $this->department = new Department;
    }

    public function hydrate()
    {
        if ( Auth::guest() || Auth::user()->cannot('viewAny', [Department::class]) ) {
            return $this->emitUp('refresh');
        }
    }

    public function unset_department()
    {
        if ( Auth::guest() || Auth::user()->cannot('create', [Department::class]) ) 
            return;
        
        $this->department_id = null;
        $this->department = new Department;
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function set_department($department_id)
    {
        $department = Department::find($department_id);
        if ( Auth::guest() || Auth::user()->cannot('update', $department) )
            return;

        $this->department_id = $department_id;
        $this->department = $department->replicate();
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function render()
    {
        return view('livewire.department.department-edit-livewire');
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function save()
    {
        $this->validate();

        $department = $this->department;
        if ( isset($this->department_id) ) {
            $department = Department::find($this->department_id);
            if ( Auth::guest() || Auth::user()->cannot('update', $department) ) 
                return;
            $department->department = $this->department->department;
            $department->description = $this->department->description;
        } elseif ( Auth::guest() || Auth::user()->cannot('create', [Department::class]) ) {
            return;
        }

        if ( !$department->save() ) 
            return;
            
        if ( $department->wasRecentlyCreated ) {
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'success',  
                'message' => 'Department Created', 
                'text' => 'Department has been successfully created'
            ]);
            $this->emitUp('department', true, $department->id);
            $this->unset_department();
            $this->dispatchBrowserEvent('department-modal', ['action' => 'hide']);
            return;

        } elseif (!$department->wasRecentlyCreated && $department->wasChanged()){
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'success',  
                'message' => 'Department Updated', 
                'text' => 'Department has been successfully updated'
            ]);
            $this->emitUp('department', false, $department->id);
            $this->unset_department();
            $this->dispatchBrowserEvent('department-modal', ['action' => 'hide']);
            return;
            
        } elseif (!$department->wasRecentlyCreated && !$department->wasChanged()){
            $this->unset_department();
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'info',  
                'message' => 'Nothing has been changed', 
                'text' => ''
            ]);
            $this->dispatchBrowserEvent('department-modal', ['action' => 'hide']);
            return;
        }
    }
}
