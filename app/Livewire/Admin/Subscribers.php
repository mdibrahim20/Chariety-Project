<?php

namespace App\Livewire\Admin;

use App\Services\NewsletterService;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.admin')]
class Subscribers extends Component
{
    use WithPagination;

    protected NewsletterService $service;

    public $search = '';
    public $statusFilter = 'all'; // all, active, unsubscribed

    public function boot(NewsletterService $service): void
    {
        $this->service = $service;
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingStatusFilter(): void
    {
        $this->resetPage();
    }

    public function delete($id): void
    {
        $this->service->deleteSubscriber($id);
        session()->flash('success', 'Subscriber deleted successfully!');
    }

    public function toggleStatus($id): void
    {
        $this->service->toggleSubscriberStatus($id);
    }

    public function exportCsv(): void
    {
        $filepath = $this->service->exportSubscribers();
        
        // Return file download
        $this->dispatch('download', ['path' => $filepath]);
        
        session()->flash('success', 'Subscribers exported successfully!');
    }

    public function render()
    {
        $query = \App\Models\Subscriber::query();

        // Apply status filter
        if ($this->statusFilter === 'active') {
            $query->active();
        } elseif ($this->statusFilter === 'unsubscribed') {
            $query->unsubscribed();
        }

        // Apply search
        if ($this->search) {
            $query->where('email', 'like', '%' . $this->search . '%');
        }

        $subscribers = $query->recent()->paginate(20);

        $stats = [
            'total' => \App\Models\Subscriber::count(),
            'active' => \App\Models\Subscriber::active()->count(),
            'unsubscribed' => \App\Models\Subscriber::unsubscribed()->count(),
        ];

        return view('livewire.admin.subscribers', [
            'subscribers' => $subscribers,
            'stats' => $stats,
        ]);
    }
}
