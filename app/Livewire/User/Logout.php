<?php

namespace App\Livewire\User;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Logout extends Component
{
    public function render()
    {
        return view('livewire.user.logout');
    }

    public function logout()
    {
        // Get the currently authenticated user
        $user = Auth::user();

        // Revoke all tokens for the user
        $user->tokens->each->delete();

        // Set custom_token to 1 after logout
        if ($user) {
            $user->update(['custom_token' => 1]);
        }

        // Logout the user
        Auth::logout();

        // Redirect to the home page
        return redirect(route('user.login'));
    }
}
