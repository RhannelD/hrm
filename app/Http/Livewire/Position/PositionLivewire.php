<?php

namespace App\Http\Livewire\Position;

use Livewire\Component;
use App\Models\Position;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PositionLivewire extends Component
{
    use AuthorizesRequests;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $search = '';
    public $row_num = 10;

    protected $listeners = [
        'refresh'   => '$refresh',
        'position' => 'position',
    ];

    public function mount()
    {
        $this->authorize('viewAny', [Position::class]);
    }

    public function hydrate()
    {
        if ( Auth::guest() || Auth::user()->cannot('viewAny', [Position::class]) ) {
            return redirect()->route('position');
        }
    }

    public function render()
    {
        return view('livewire.position.position-livewire', [
                'positions' => $this->get_positions(),
            ])
            ->extends('livewire.main.main');
    }
    
    public function get_positions()
    {
        $search = $this->search;
        return Position::where('position', 'like', "%{$search}%")
            ->orderBy('position')
            ->paginate($this->row_num);
    }
    
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function position($created, $position_id)
    {
        if ($created) 
            return session()->flash("position-{$position_id}", 'table-success');
        return session()->flash("position-{$position_id}", 'table-info');
    }

    public function get_position($position_id)
    {
        return Position::find($position_id);
    }

    public function delete_confirm($position_id)
    {
        if ( Auth::guest() || Auth::user()->cannot('delete', $this->get_position($position_id)) ) 
            return;
        
        $this->dispatchBrowserEvent('swal:confirm:delete_position', [
            'type' => 'warning',  
            'message' => 'Are you sure?', 
            'text' => 'If deleted, you will not be able to recover this position!',
            'position_id' => $position_id,
        ]);
    }

    public function delete_position($position_id)
    {
        $position = $this->get_position($position_id);
        if ( Auth::guest() || Auth::user()->cannot('delete', $position) ) 
            return;

        if ( $position->delete() ) {
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'success',
                'message' => 'Position Deleted', 
                'text' => 'Position has been successfully deleted'
            ]);
        }
    }
}
