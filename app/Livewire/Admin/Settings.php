<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use App\Models\Value;
use App\Models\Value1;

class Settings extends Component
{
    public $currentPassword;
    public $newPassword;
    public $confirmNewPassword;
    public $location;
    public $restrict;
    public $file;
    public $administrative;
    public $financial;
    public $legal;
    public $personnel;
    public $social;
    public $doc;

    public function render()
    {
        return view('livewire.admin.settings')->layout('layouts.admin-app');
    }

    public function changePassword()
    {
        $this->validate([
            'currentPassword' => 'required',
            'newPassword' => 'required|min:8|different:currentPassword',
            'confirmNewPassword' => 'required|same:newPassword',
        ]);

        // Check if the current password matches the authenticated user's password
        if (!Hash::check($this->currentPassword, auth()->user()->password)) {
            $this->addError('currentPassword', 'The current password is incorrect.');
            return;
        }

        // Update the user's password
        auth()->user()->update([
            'password' => bcrypt($this->newPassword),
        ]);

        // Reset the form fields
        $this->currentPassword = '';
        $this->newPassword = '';
        $this->confirmNewPassword = '';

        session()->flash('message', 'Password changed successfully!');
    }
    public function addValue()
    {
        $this->validate([
            'location' => 'sometimes|max:50',
            'restrict' => 'sometimes|max:50',
            'file' => 'sometimes|max:50',
            'administrative' => 'sometimes|max:80',
            'financial' => 'sometimes|max:80',
            'legal' => 'sometimes|max:80',
            'personnel' => 'sometimes|max:80',
            'social' => 'sometimes|max:80',
            'doc' => 'sometimes|max:20',
        ]);

        // Create a new Value model instance and save it to the database
        Value::create([
            'location' => $this->location,
            'restrict' => $this->restrict,
            'file' => $this->file,
            'administrative' => $this->administrative,
            'financial' => $this->financial,
            'legal' => $this->legal,
            'personnel' => $this->personnel,
            'social' => $this->social,
            'doc' => $this->doc,
        ]);

        // Reset the form fields
        $this->location = '';
        $this->restrict = '';
        $this->file = '';
        $this->administrative = '';
        $this->financial = '';
        $this->legal = '';
        $this->personnel = '';
        $this->social = '';
        $this->doc = '';

        session()->flash('message', 'Value added successfully!');
    }

}
