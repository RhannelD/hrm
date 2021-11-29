<?php

namespace App\Http\Livewire\Position;

use Livewire\Component;
use App\Models\Position;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PositionShowLivewire extends Component
{
    use AuthorizesRequests;
    
    public $position_id;
    
    public function mount($position_id)
    {
        $this->position_id = $position_id;
        $position = $this->get_position();

        abort_if(is_null($position), '404');
        $this->authorize('view', $position);
    }

    public function render()
    {
        return view('livewire.position.position-show-livewire', [
                'position' => $this->get_position(),
            ])
            ->extends('livewire.main.main');
    }

    public function get_position()
    {
        return Position::find($this->position_id);
    }
}
