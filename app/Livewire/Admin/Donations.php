<?php

namespace App\Livewire\Admin;

use App\Models\Donation;
use App\Models\Event;
use App\Services\DonationService;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.admin')]
class Donations extends Component
{
    use WithPagination;

    protected DonationService $service;

    public $search = '';
    public $eventFilter = '';
    public $statusFilter = '';
    public $methodFilter = '';

    public function boot(DonationService $service) { $this->service = $service; }

    public function updatingSearch() { $this->resetPage(); }
    public function updatingEventFilter() { $this->resetPage(); }
    public function updatingStatusFilter() { $this->resetPage(); }
    public function updatingMethodFilter() { $this->resetPage(); }

    public function updateStatus($id, $status)
    {
        $donation = Donation::findOrFail($id);
        $this->service->updateStatus($donation, $status);
        session()->flash('success', 'Status updated');
    }

    public function delete($id)
    {
        Donation::findOrFail($id)->delete();
        session()->flash('success', 'Donation deleted');
    }

    public function exportCsv()
    {
        $path = $this->service->exportCsv(
            $this->eventFilter ?: null,
            $this->statusFilter ?: null,
            $this->methodFilter ?: null
        );
        $this->dispatch('download', ['path' => $path]);
        session()->flash('success', 'CSV exported');
    }

    public function render()
    {
        $query = Donation::with('event');
        if ($this->search) {
            $query->where(function($q) {
                $q->where('email', 'like', "%{$this->search}%")
                  ->orWhere('full_name', 'like', "%{$this->search}%");
            });
        }
        if ($this->eventFilter) $query->where('event_id', $this->eventFilter);
        if ($this->statusFilter) $query->where('status', $this->statusFilter);
        if ($this->methodFilter) $query->where('payment_method', $this->methodFilter);

        $donations = $query->orderByDesc('id')->paginate(20);
        $events = Event::all();

        return view('livewire.admin.donations', [
            'donations' => $donations,
            'events' => $events,
            'stats' => [
                'total' => Donation::count(),
                'pending' => Donation::where('status','pending')->count(),
                'confirmed' => Donation::where('status','confirmed')->count(),
            ],
        ]);
    }
}
