<?php

namespace App\Http\Livewire\Attendance;

use Livewire\Component;
use App\Models\Attendance;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class AttendanceShowLivewire extends Component
{
    use AuthorizesRequests;

    public $attendance_id;
    
    public function mount($attendance_id)
    {
        $this->attendance_id = $attendance_id;
        $attendance = $this->get_attendance();

        abort_if(is_null($attendance), '404');
        $this->authorize('view', $attendance);
    }

    public function render()
    {
        return view('livewire.attendance.attendance-show-livewire', [
                'attendance' => $this->get_attendance(),
            ])
            ->extends('livewire.main.main');
    }

    public function get_attendance()
    {
        return Attendance::find($this->attendance_id);
    }
}
