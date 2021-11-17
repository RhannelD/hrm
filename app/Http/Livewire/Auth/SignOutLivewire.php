<?php

namespace App\Http\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class SignOutLivewire extends Component
{
    public function render()
    {
        return view('livewire.auth.sign-out-livewire');
    }
    
    public function signout(){
        Auth::logout();

        redirect()->route('index');
    }
}
