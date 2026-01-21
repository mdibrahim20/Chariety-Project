<?php

namespace App\Livewire\Admin\Roles;

use App\Models\Role;
use Livewire\Component;

class Index extends Component
{
    public function delete($roleId)
    {
        $role = Role::findOrFail($roleId);
        
        try {
            if ($role->slug === 'admin') {
                session()->flash('error', 'Cannot delete the admin role.');
                return;
            }

            $role->delete();
            session()->flash('success', 'Role deleted successfully.');
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }
    }

    public function render()
    {
        $roles = Role::withCount('users', 'permissions')->get();
        return view('livewire.admin.roles.index', ['roles' => $roles])->layout('layouts.admin');
    }
}
