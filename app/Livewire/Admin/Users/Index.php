<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public string $search = '';
    public string $filter = 'all';

    protected $queryString = ['search', 'filter'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function delete($userId)
    {
        $user = User::findOrFail($userId);
        
        try {
            $user->delete();
            session()->flash('success', 'User deleted successfully.');
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }
    }

    public function render()
    {
        $query = User::query();

        if ($this->search) {
            $query->where(function($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->filter === 'admin') {
            $query->where('is_admin', true);
        } elseif ($this->filter === 'with_2fa') {
            $query->whereHas('twoFactorAuth', function($q) {
                $q->where('enabled', true);
            });
        } elseif ($this->filter === 'without_2fa') {
            $query->whereDoesntHave('twoFactorAuth', function($q) {
                $q->where('enabled', true);
            });
        }

        $users = $query->with('roles')->latest()->paginate(10);

        return view('livewire.admin.users.index', ['users' => $users])->layout('layouts.admin');
    }
}
