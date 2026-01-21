<?php

namespace App\Livewire\Admin\Services;

use App\Models\Service;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.admin')]
class ServicesIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = '';

    public function updatingSearch() { $this->resetPage(); }
    public function updatingStatusFilter() { $this->resetPage(); }

    public function toggleStatus($id)
    {
        $service = Service::findOrFail($id);
        $service->is_active = !$service->is_active;
        $service->save();
    }

    public function toggleFeatured($id)
    {
        $service = Service::findOrFail($id);
        $service->is_featured = !$service->is_featured;
        $service->save();
    }

    public function delete($id)
    {
        Service::findOrFail($id)->delete();
        session()->flash('success', 'Service deleted successfully');
    }

    public function updateOrder($items)
    {
        foreach ($items as $item) {
            Service::where('id', $item['value'])->update(['display_order' => $item['order']]);
        }
    }

    public function render()
    {
        $query = Service::query();
        
        if ($this->search) {
            $query->where('title', 'like', "%{$this->search}%");
        }
        
        if ($this->statusFilter !== '') {
            $query->where('is_active', $this->statusFilter === 'active');
        }

        $services = $query->ordered()->paginate(15);

        return view('livewire.admin.services.services-index', [
            'services' => $services,
        ]);
    }
}
