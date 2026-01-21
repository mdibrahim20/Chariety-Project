<?php

namespace App\Livewire\Admin\Roles;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Support\Str;
use Livewire\Component;

class Create extends Component
{
    public string $name = '';
    public string $slug = '';
    public string $description = '';
    public array $selectedPermissions = [];

    protected $rules = [
        'name' => 'required|string|max:255',
        'slug' => 'required|string|max:255|unique:roles,slug',
        'description' => 'nullable|string',
    ];

    public function updatedName()
    {
        $this->slug = Str::slug($this->name);
    }

    public function save()
    {
        $this->validate();

        $role = Role::create([
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
        ]);

        if (!empty($this->selectedPermissions)) {
            $role->permissions()->sync($this->selectedPermissions);
        }

        session()->flash('success', 'Role created successfully.');
        return redirect()->route('admin.roles.index');
    }

    public function render()
    {
        $permissions = Permission::all();
        return view('livewire.admin.roles.create', ['permissions' => $permissions])->layout('layouts.admin');
    }
}
