<?php

namespace App\Http\Livewire\Position;

use Livewire\Component;
use App\Models\Position;
use Illuminate\Support\Facades\Auth;

class PositionEditLivewire extends Component
{
    public $position_id;

    public $position;

    function rules()
    {
        return [
            "position.position" => "required|min:3|max:180|unique:positions,position".(isset($this->position_id)? ",{$this->position_id}": ""),
            "position.salary" => "required|numeric|min:1|max:10000000",
        ];
    }

    public function mount()
    {
        $this->position = new Position;
    }

    public function hydrate()
    {
        if ( Auth::guest() || Auth::user()->cannot('viewAny', [Position::class]) ) {
            return $this->emitUp('refresh');
        }
    }

    public function unset_position()
    {
        if ( Auth::guest() || Auth::user()->cannot('create', [Position::class]) ) 
            return;
        
        $this->position_id = null;
        $this->position = new Position;
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function set_position($position_id)
    {
        $position = Position::find($position_id);
        if ( Auth::guest() || Auth::user()->cannot('update', $position) )
            return;

        $this->position_id = $position_id;
        $this->position->position = $position->position;
        $this->position->salary   = $position->salary;
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function render()
    {
        return view('livewire.position.position-edit-livewire');
    }
    
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function save()
    {
        $this->validate();

        $position = $this->position;
        if ( isset($this->position_id) ) {
            $position = Position::find($this->position_id);
            if ( Auth::guest() || Auth::user()->cannot('update', $position) ) 
                return;
            $position->position = $this->position->position;
            $position->salary   = $this->position->salary;
        } elseif ( Auth::guest() || Auth::user()->cannot('create', [Position::class]) ) {
            return;
        }

        if ( !$position->save() ) 
            return;
            
        if ( $position->wasRecentlyCreated ) {
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'success',  
                'message' => 'Position Created', 
                'text' => 'Position has been successfully created'
            ]);
            $this->emitUp('position', true, $position->id);
            $this->unset_position();
            $this->dispatchBrowserEvent('position-modal', ['action' => 'hide']);
            return;

        } elseif (!$position->wasRecentlyCreated && $position->wasChanged()){
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'success',  
                'message' => 'Position Updated', 
                'text' => 'Position has been successfully updated'
            ]);
            $this->emitUp('position', false, $position->id);
            $this->unset_position();
            $this->dispatchBrowserEvent('position-modal', ['action' => 'hide']);
            return;
            
        } elseif (!$position->wasRecentlyCreated && !$position->wasChanged()){
            $this->unset_position();
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'info',  
                'message' => 'Nothing has been changed', 
                'text' => ''
            ]);
            $this->dispatchBrowserEvent('position-modal', ['action' => 'hide']);
            return;
        }
    }
}
