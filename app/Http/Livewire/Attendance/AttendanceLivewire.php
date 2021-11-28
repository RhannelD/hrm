<?php

namespace App\Http\Livewire\Attendance;

use Livewire\Component;
use App\Models\Attendance;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class AttendanceLivewire extends Component
{
    use AuthorizesRequests;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $search = '';
    public $row_num = 10;

    protected $listeners = [
        'refresh'   => '$refresh',
        'attendance' => 'attendance',
    ];

    public function mount()
    {
        $this->authorize('viewAny', [Attendance::class]);
    }

    public function hydrate()
    {
        if ( Auth::guest() || Auth::user()->cannot('viewAny', [Attendance::class]) ) {
            return redirect()->route('attendance');
        }
    }

    public function render()
    {
        return view('livewire.attendance.attendance-livewire', [
                'attendances' => $this->get_attendances(),
            ])
            ->extends('livewire.main.main');
    }
    
    public function get_attendances()
    {
        $search = $this->search;
        return Attendance::where('attendance', 'like', "%{$search}%")
            ->whereAttendance()
            ->orderBy('attendance')
            ->paginate($this->row_num);
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function attendance($created, $attendance_id)
    {
        if ($created) 
            return session()->flash("attendance-{$attendance_id}", 'table-success');
        return session()->flash("attendance-{$attendance_id}", 'table-info');
    }

    public function get_attendance($attendance_id)
    {
        return Attendance::find($attendance_id);
    }

    public function delete_confirm($attendance_id)
    {
        if ( Auth::guest() || Auth::user()->cannot('delete', $this->get_attendance($attendance_id)) ) 
            return;
        
        $this->dispatchBrowserEvent('swal:confirm:delete_attendance', [
            'type' => 'warning',  
            'message' => 'Are you sure?', 
            'text' => 'If deleted, you will not be able to recover this attendance!',
            'attendance_id' => $attendance_id,
        ]);
    }

    public function delete_attendance($attendance_id)
    {
        $attendance = $this->get_attendance($attendance_id);
        if ( Auth::guest() || Auth::user()->cannot('delete', $attendance) ) 
            return;

        if ( $attendance->delete() ) {
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'success',
                'message' => 'Attendance Deleted', 
                'text' => 'Attendance has been successfully deleted'
            ]);
        }
    }
}
