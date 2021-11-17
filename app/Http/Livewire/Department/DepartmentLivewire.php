<?php

namespace App\Http\Livewire\Department;

use Livewire\Component;
use App\Models\Department;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class DepartmentLivewire extends Component
{
    use AuthorizesRequests;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $search = '';
    public $row_num = 10;

    protected $listeners = [
        'refresh'   => '$refresh',
        'department' => 'department',
    ];

    public function mount()
    {
        $this->authorize('viewAny', [Department::class]);
    }

    public function hydrate()
    {
        if ( Auth::guest() || Auth::user()->cannot('viewAny', [Department::class]) ) {
            return redirect()->route('department');
        }
    }

    public function render()
    {
        return view('livewire.department.department-livewire', [
                'departments' => $this->get_departments(),
            ])
            ->extends('livewire.main.main');
    }

    public function get_departments()
    {
        $search = $this->search;
        return Department::where('department', 'like', "%{$search}%")
            ->orderBy('department')
            ->paginate($this->row_num);
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function department($created, $department_id)
    {
        if ($created) 
            return session()->flash("department-{$department_id}", 'table-success');
        return session()->flash("department-{$department_id}", 'table-info');
    }

    public function get_department($department_id)
    {
        return Department::find($department_id);
    }

    public function delete_confirm($department_id)
    {
        if ( Auth::guest() || Auth::user()->cannot('delete', $this->get_department($department_id)) ) 
            return;
        
        $this->dispatchBrowserEvent('swal:confirm:delete_department', [
            'type' => 'warning',  
            'message' => 'Are you sure?', 
            'text' => 'If deleted, you will not be able to recover this department!',
            'course_id' => $department_id,
        ]);
    }

    public function delete_department($department_id)
    {
        $department = $this->get_department($department_id);
        if ( Auth::guest() || Auth::user()->cannot('delete', $department) ) 
            return;

        if ( $department->delete() ) {
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'success',
                'message' => 'Department Deleted', 
                'text' => 'Department has been successfully deleted'
            ]);
        }
    }
}
