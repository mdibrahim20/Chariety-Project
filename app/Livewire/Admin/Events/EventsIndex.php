<?php

namespace App\Livewire\Admin\Events;

use App\Models\Event;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.admin')]
class EventsIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = '';

    public function updatingSearch() { $this->resetPage(); }
    public function updatingStatusFilter() { $this->resetPage(); }

    public function toggleStatus($id)
    {
        $event = Event::findOrFail($id);
        $event->is_active = !$event->is_active;
        $event->save();
    }

    public function delete($id)
    {
        Event::findOrFail($id)->delete();
        session()->flash('success', 'Event deleted successfully');
    }

    public function render()
    {
        $query = Event::query();
        if ($this->search) {
            $query->where('title', 'like', "%{$this->search}%");
        }
        if ($this->statusFilter !== '') {
            $query->where('is_active', $this->statusFilter === 'active');
        }
        $events = $query->orderBy('ordering')->orderByDesc('id')->paginate(15);

        return view('livewire.admin.events.index', [
            'events' => $events,
        ]);
    }
}
