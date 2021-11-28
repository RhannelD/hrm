<?php

namespace App\Http\Livewire\Employee;

use App\Models\User;
use Livewire\Component;
use App\Models\Position;
use App\Models\Department;
use App\Models\EmployeePosition;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class EmployeeEditLivewire extends Component
{
    public $user_id;

    public $user;
    public $employee;
    public $password;

    function rules()
    {
        return [
            'user.firstname' => 'required|regex:/^[a-z ,.\'-]+$/i',
            'user.lastname' => 'required|regex:/^[a-z ,.\'-]+$/i',
            'user.gender' => 'required|in:male,female',
            'user.email' => "required|unique:users,email".((isset($this->user_id))?",".$this->user_id:'')."|email",
            "employee.department_id" => "required|exists:departments,id",
            "employee.position_id" => "required|exists:positions,id",
            "password" => 'required|min:6',
        ];
    }

    protected $messages = [
        "employee.department_id.required" => "Please select a department",
        "employee.department_id.exists" => "Please select a department",
        "employee.position_id.required" => "Please select a position",
        "employee.position_id.exists" => "Please select a position",
    ];

    public function mount()
    {
        $this->user = new User;
        $this->user->gender = 'male';
        $this->employee = new EmployeePosition;
    }

    public function hydrate()
    {
        if ( Auth::guest() || Auth::user()->cannot('viewAny', [EmployeePosition::class]) ) {
            return $this->emitUp('refresh');
        }
    }

    public function unset_user()
    {
        if ( Auth::guest() || Auth::user()->cannot('create', [User::class]) ) 
            return;
        
        $this->user_id = null;
        $this->user = new User;
        $this->user->gender = 'male';
        $this->employee = new EmployeePosition;
        $this->password = null;
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function set_user($user_id)
    {
        $user = User::with('employee_position')->where('id', $user_id)->first();
        if ( Auth::guest() || Auth::user()->cannot('update', $user) )
            return;

        $this->user_id = $user_id;
        $this->user = $user->replicate();
        $this->employee = isset($user->employee_position)?  $user->employee_position->replicate(): new EmployeePosition;
        $this->password = '123123123';
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function render()
    {
        return view('livewire.employee.employee-edit-livewire', [
            'departments' => $this->get_departments(),
            'positions' => $this->get_positions(),
        ]);
    }
    
    public function get_departments()
    {
        return Department::all();
    }

    public function get_positions()
    {
        return Position::all();
    }
    
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function save()
    {
        $this->validate();

        $this->user->usertype = 'emp';
        $this->user->password = Hash::make($this->password);
        $user     = $this->user;
        $employee = $this->employee;

        if ( isset($this->user_id) ) {
            $user = User::find($this->user_id);
            if ( Auth::guest() || Auth::user()->cannot('update', $user) ) 
                return;
            if ( isset($user->employee_position) ) {
                $employee = $user->employee_position;
            } else {
                $employee->user_id = $user->id;
            }
            
            $user->firstname  = $this->user->firstname;
            $user->lastname   = $this->user->lastname;
            $user->gender     = $this->user->gender;
            $user->email      = $this->user->email;
            $employee->department_id = $this->employee->department_id;
            $employee->position_id   = $this->employee->position_id;
        } elseif ( Auth::guest() || Auth::user()->cannot('create', [User::class]) ) {
            return;
        }

        if ( !$user->save() ) 
            return;

        if ( is_null($this->user_id) ) {
            $employee->user_id = $user->id;
        }

        $employee->save();
            
        if ( $user->wasRecentlyCreated ) {
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'success',  
                'message' => 'Employee Created', 
                'text' => 'Employee has been successfully created'
            ]);
            $this->emitUp('employee', true, $user->id);
            $this->unset_user();
            $this->dispatchBrowserEvent('user-modal', ['action' => 'hide']);
            return;

        } elseif ( !$user->wasRecentlyCreated && ($user->wasChanged() || $employee->wasRecentlyCreated || $employee->wasChanged() ) ){
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'success',  
                'message' => 'Employee Updated', 
                'text' => 'Employee has been successfully updated'
            ]);
            $this->emitUp('employee', false, $user->id);
            $this->unset_user();
            $this->dispatchBrowserEvent('user-modal', ['action' => 'hide']);
            return;
            
        } elseif (!$user->wasRecentlyCreated && !$user->wasChanged()){
            $this->unset_user();
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'info',  
                'message' => 'Nothing has been changed', 
                'text' => ''
            ]);
            $this->dispatchBrowserEvent('user-modal', ['action' => 'hide']);
            return;
        }
    }
}
