<?php

namespace App\Http\Livewire\Auth;

use App\Models\User;
use Livewire\Component;
use App\Models\PasswordReset;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Notifications\PasswordResetNotification;

class ForgotPasswordLivewire extends Component
{
    public $email;
    public $code;
    
    public $sent = false;
    public $verify_code = false;
    
    public $new_password;
    public $confirm_password;

    protected $rules = [
        'email' => 'required|email|exists:users,email',
        'code' => 'required|min:6|max:6',
        'new_password' => 'required|min:6',
        'confirm_password' => 'required|min:6|same:new_password',
    ];

    protected $messages = [
        'email.required' => 'The Email Address cannot be empty.',
        'email.email' => 'The Email Address format is not valid.',
        'email.exists' => 'This email address does not exist.',
    ];
    
    public function render()
    {
        return view('livewire.auth.forgot-password-livewire');
    }
    
    public function search()
    {
        $this->validateOnly('email');

        $user = $this->get_user();
        if ( !$user ) 
            return;

        $token = rand(111111, 999999);

        PasswordReset::where('email', $this->email)->delete();
        
        $passwordreset = new PasswordReset;
        $passwordreset->email = $this->email;
        $passwordreset->token = Hash::make($token);
        if ($passwordreset->save()) {
            $this->sent = $this->send_mail($user, $token);
        }
    }
    
    protected function send_mail($user, $token)
    {
        try {
            $user->notify(new PasswordResetNotification($token));
            session()->flash('message-success', 'Password reset code has been sent to your email.');
            return true;
        } catch (\Exception $e) {
            session()->flash('message-error', "Email has not been sent!");
        }
        return false;
    }

    public function updated($propertyName)
    {
        if ( $propertyName != 'email')
            $this->validateOnly($propertyName);
    }

    protected function get_user()
    {
        return User::where('email', $this->email)->first();
    }

    public function verify_code()
    {
        $this->validateOnly('code');

        $this->verify_code = $this->get_password_reset();
        if ( !$this->verify_code ) {
            $this->addError('code', 'Entered code is incorrect!');
        }
    }
    
    protected function get_password_reset()
    {
        $user = $this->get_user();
        if ( !$user ) 
            return false;
        
        $password_reset = PasswordReset::where('email', $this->email)
            ->first();
        if ( is_null($password_reset) ) 
            return false;
        
        return Hash::check($this->code, $password_reset->token)? $password_reset: null;
    }

    public function save()
    {
        $this->validate();

        $password_reset = $this->get_password_reset();
        if ( !($password_reset) ) 
            return;

        $user =  $this->get_user();
        if ( Hash::check($this->new_password, $user->password) ) 
            return $this->addError('new_password', 'This is your old password.');

        $user->password = Hash::make($this->new_password);

        if ( $user->save() ) {    
            PasswordReset::where('email', $this->email)->delete();
            
            if (Auth::attempt(['email' => $this->email, 'password' => $this->new_password])) {
                return redirect()->route('index');
            }
        }
    }
}
