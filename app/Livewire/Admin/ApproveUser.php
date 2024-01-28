<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;

class ApproveUser extends Component
{
    use WithPagination;

    public function render()
    {
        $users = User::orderBy('id', 'DESC')->paginate(6);
        $totalUser = User::count();

        return view('livewire.admin.approve-user', compact('users', 'totalUser'))->layout('layouts.admin-app');
    }

    public function approve($id)
    {
        $user = User::findOrFail($id);
        $user->custom_token = 1;
        $user->save();
        session()->flash('success', 'User approved successfully.');
    }

    public function remove($id)
    {
        $user = User::findOrFail($id);
        $user->custom_token = 0;
        $user->save();
        session()->flash('removed', 'User removed successfully.');
    }

    public function delete($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        // Check if the table is empty
        if (User::count() === 0) {
            DB::statement('ALTER TABLE users AUTO_INCREMENT = 1');
        }

        session()->flash('success', 'User deleted successfully.');
    }
}
