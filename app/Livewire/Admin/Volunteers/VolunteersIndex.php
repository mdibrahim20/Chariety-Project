<?php

namespace App\Livewire\Admin\Volunteers;

use App\Models\Volunteer;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.admin')]
class VolunteersIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = '';

    public function updatingSearch() { $this->resetPage(); }
    public function updatingStatusFilter() { $this->resetPage(); }

    public function toggleStatus($id)
    {
        $volunteer = Volunteer::findOrFail($id);
        $volunteer->is_active = !$volunteer->is_active;
        $volunteer->save();
    }

    public function delete($id)
    {
        Volunteer::findOrFail($id)->delete();
        session()->flash('success', 'Volunteer deleted successfully');
    }

    public function updateOrder($items)
    {
        foreach ($items as $item) {
            Volunteer::where('id', $item['value'])->update(['display_order' => $item['order']]);
        }
    }

    public function render()
    {
        $query = Volunteer::query();
        
        if ($this->search) {
            $query->where('name', 'like', "%{$this->search}%")
                  ->orWhere('designation', 'like', "%{$this->search}%");
        }
        
        if ($this->statusFilter !== '') {
            $query->where('is_active', $this->statusFilter === 'active');
        }

        $volunteers = $query->ordered()->paginate(15);

        return view('livewire.admin.volunteers.volunteers-index', [
            'volunteers' => $volunteers,
        ]);
    }
}
