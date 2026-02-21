<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserManager extends Component
{
    public $name, $username, $password, $role = 'cashier';

    public function saveUser()
    {
        $this->validate([
            'name' => 'required',
            'username' => 'required|unique:users,username',
            'password' => 'required|min:6',
            'role' => 'required'
        ]);

        User::create([
            'name' => $this->name,
            'username' => $this->username,
            'password' => Hash::make($this->password),
            'role' => $this->role,
        ]);

        $this->reset(['name', 'username', 'password', 'role']);
        session()->flash('success', 'Pegawai baru resmi bergabung ke dalam tim');
    }

    public function render()
    {
        return view('livewire.user-manager', [
            'users' => User::latest()->get()
        ])->layout('components.layouts.app');
    }
}