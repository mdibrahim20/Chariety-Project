<?php

namespace App\Livewire\Admin\Roles;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Support\Str;
use Livewire\Component;

class Edit extends Component
{
    public Role $role;
    public string $name = '';
    public string $slug = '';
    public string $description = '';
    public array $selectedPermissions = [];

    public function mount(Role $role)
    {
        $this->role = $role;
        $this->name = $role->name;
        $this->slug = $role->slug;
        $this->description = $role->description ?? '';
        $this->selectedPermissions = $role->permissions->pluck('id')->toArray();
    }

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:roles,slug,' . $this->role->id,
            'description' => 'nullable|string',
        ];
    }

    public function updatedName()
    {
        if ($this->role->slug !== 'admin') {
            $this->slug = Str::slug($this->name);
        }
    }

    public function save()
    {
        $this->validate();

        $this->role->update([
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
        ]);

        $this->role->permissions()->sync($this->selectedPermissions);

        session()->flash('success', 'Role updated successfully.');
        return redirect()->route('admin.roles.index');
    }

    public function render()
    {
        $permissions = Permission::all();
        return view('livewire.admin.roles.edit', ['permissions' => $permissions])->layout('layouts.admin');
    }
}
