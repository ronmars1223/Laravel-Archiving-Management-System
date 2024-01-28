<?php

namespace App\Livewire\User;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Login extends Component
{
    public $email, $password;

    public function render()
    {
        return view('livewire.user.login')->layout('layouts.user-login');
    }

    public function login()
    {
        $this->validate([
            'email' => ['email', 'required'],
            'password' => ['required', 'string', 'min:3', 'max:12']
        ]);

        $authenticated = Auth::attempt(['email' => $this->email, 'password' => $this->password]);

        if ($authenticated) {
            $user = Auth::user();

            if ($user->custom_token != 1) {
                Auth::logout(); // Log out the user
                $this->reset(); // Reset the form fields
                session()->flash('error', 'Still not Approved by the Admin.');
            } else {
                return redirect(route('user.dashboard'));
            }
        } else {
            session()->flash('error', 'Invalid Email and password');
        }
    }
}
