<?php

namespace App\Http\Livewire\Profile;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class ProfileLivewire extends Component
{
    public function mount()
    {
        abort_if(Auth::guest(), '403');
    }

    public function hydrate()
    {
        if ( Auth::guest() ) {
            return redirect()->route('profile');
        }
    }

    public function render()
    {
        return view('livewire.profile.profile-livewire', [
                'user' => $this->get_user()
            ])
            ->extends('livewire.main.main');
    }

    public function get_user()
    {
        return Auth::user();
    }
}
