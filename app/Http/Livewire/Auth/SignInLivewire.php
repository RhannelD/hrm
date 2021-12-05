<?php

namespace App\Http\Livewire\Auth;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Notifications\EnteredWrongPasswordNotification;

class SignInLivewire extends Component
{
    public $email;
    public $password;

    protected $rules = [
        'email' => 'required|email',
        'password' => 'required|min:6',
    ];

    protected $messages = [
        'email.required' => 'Email address cannot be empty.',
        'email.email' => 'Email address format is not valid.',
        'password.required' => 'Password cannot be empty.',
        'password.min' => 'Password must be at least 6 characters.',
    ];

    public function render()
    {
        return view('livewire.auth.sign-in-livewire')
            ->extends('layouts.app')
            ->slot('main');
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function signin()
    {
        $this->validate();

        if (Auth::attempt(['email' => $this->email, 'password' => $this->password])) {
            return redirect()->route('employee');
        }
        $this->password = '';

        $this->notify_email_of_malicious_access();

        $this->dispatchBrowserEvent('swal:modal', [
            'type' => 'error',  
            'message' => '', 
            'text' => 'Email and Password does not match'
        ]);
    }

    public function notify_email_of_malicious_access()
    {
        $user = User::where('email', $this->email)->first();

        if ( $user ) {
            try {
                $user->notify(new EnteredWrongPasswordNotification());
            } catch (\Exception $e) {
            }
        }
    }
}
