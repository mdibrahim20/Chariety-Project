<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Create extends Component
{
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';
    public bool $is_admin = false;
    public bool $two_factor_required = false;
    public array $selectedRoles = [];

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:8|confirmed',
        'is_admin' => 'boolean',
        'two_factor_required' => 'boolean',
    ];

    public function save()
    {
        $this->validate();

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'is_admin' => $this->is_admin,
            'two_factor_required' => $this->two_factor_required,
            'email_verified_at' => now(),
        ]);

        if (!empty($this->selectedRoles)) {
            $user->roles()->sync($this->selectedRoles);
        }

        session()->flash('success', 'User created successfully.');
        return redirect()->route('admin.users.index');
    }

    public function render()
    {
        $roles = Role::all();
        return view('livewire.admin.users.create', ['roles' => $roles])->layout('layouts.admin');
    }
}
