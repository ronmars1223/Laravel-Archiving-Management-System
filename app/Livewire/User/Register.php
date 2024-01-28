<?php

namespace App\Livewire\User;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Register extends Component
{
    public $fname,
        $mname,
        $lname,
        $email,
        $password;
    public function render()
    {
        return view('livewire.user.register')->layout('layouts.user-login');
    }
    public function create()
    {
        $users = new User();
        $this->validate([
            'fname' => ['required', 'string', 'min:3', 'max:12'],
            'mname' => ['nullable', 'string','max:1'],
            'lname' => ['required', 'string', 'min:3', 'max:12'],
            'email' => ['required', 'email', 'unique:users', 'max:30'],
            'password' => ['required', 'string', 'min:3', 'max:12'],
        ]);

        $users->fname = $this->fname;
        $users->mname = $this->mname;
        $users->lname = $this->lname;
        $users->email = $this->email;
        $users->password = Hash::make($this->password);
        $users->remember_token = 0;
        $result = $users->save();
        if ($result) {
            session()->flash('success', 'Registration Successfully Admin will approve your account ');
            $this->fname = '';
            $this->mname = '';
            $this->lname = '';
            $this->email = '';
            $this->password = '';
            return redirect(route('user.login'));
        }
    }
}
