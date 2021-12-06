<?php

namespace App\Http\Livewire\Leave;

use Livewire\Component;
use App\Models\Attendance;
use Illuminate\Support\Facades\Auth;

class LeaveEditLivewire extends Component
{
    public $attendance_id;

    public $attendance;

    function rules()
    {
        return [
            "attendance.attendance" => "required|min:3|max:200|unique:attendances,attendance".((isset($this->attendance_id))?",".$this->attendance_id:''),
            "attendance.payment" => "required|numeric|min:0|max:999",
            "attendance.description" => "max:65000",
        ];
    }

    protected $messages = [
        'attendance.attendance.required' => 'The leave field is required.',
        'attendance.attendance.min' => 'The leave must be at least 3 characters.',
        'attendance.attendance.max' => 'The leave must not be greater than 200 characters.',
        'attendance.attendance.unique' => 'The leave name has already been taken on leaves and attendances.',
    ];

    public function mount()
    {
        $this->attendance = new Attendance;
        $this->attendance->payment = 100;
    }

    public function hydrate()
    {
        if ( Auth::guest() || Auth::user()->cannot('viewAny', [Attendance::class]) ) {
            return $this->emitUp('refresh');
        }
    }

    public function unset_attendance()
    {
        if ( Auth::guest() || Auth::user()->cannot('create', [Attendance::class]) ) 
            return;
        
        $this->attendance_id = null;
        $this->attendance = new Attendance;
        $this->attendance->payment = 100;
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function set_attendance($attendance_id)
    {
        $attendance = Attendance::find($attendance_id);
        if ( Auth::guest() || Auth::user()->cannot('update', $attendance) )
            return;

        $this->attendance_id = $attendance_id;
        $this->attendance = $attendance->replicate();
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function render()
    {
        return view('livewire.leave.leave-edit-livewire');
    }
    
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function save()
    {
        $this->validate();

        $attendance = $this->attendance;
        $attendance->type = 'leave';

        if ( isset($this->attendance_id) ) {
            $attendance = Attendance::find($this->attendance_id);
            if ( Auth::guest() || Auth::user()->cannot('update', $attendance) ) 
                return;
            $attendance->attendance = $this->attendance->attendance;
            $attendance->payment    = $this->attendance->payment;
            $attendance->description= $this->attendance->description;
        } elseif ( Auth::guest() || Auth::user()->cannot('create', [Attendance::class]) ) {
            return;
        }

        if ( !$attendance->save() ) 
            return;
            
        if ( $attendance->wasRecentlyCreated ) {
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'success',  
                'message' => 'Leave Created', 
                'text' => 'Leave has been successfully created'
            ]);
            $this->emitUp('attendance', true, $attendance->id);
            $this->unset_attendance();
            $this->dispatchBrowserEvent('attendance-modal', ['action' => 'hide']);
            return;

        } elseif (!$attendance->wasRecentlyCreated && $attendance->wasChanged()){
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'success',  
                'message' => 'Leave Updated', 
                'text' => 'Leave has been successfully updated'
            ]);
            $this->emitUp('attendance', false, $attendance->id);
            $this->unset_attendance();
            $this->dispatchBrowserEvent('attendance-modal', ['action' => 'hide']);
            return;
            
        } elseif (!$attendance->wasRecentlyCreated && !$attendance->wasChanged()){
            $this->unset_attendance();
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'info',  
                'message' => 'Nothing has been changed', 
                'text' => ''
            ]);
            $this->dispatchBrowserEvent('attendance-modal', ['action' => 'hide']);
            return;
        }
    }
}
