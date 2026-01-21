<?php

namespace App\Livewire\Frontend;

use App\Models\Event;
use Livewire\Component;

class EventDetails extends Component
{
    public string $slug;
    public ?Event $event = null;

    public function mount(string $slug)
    {
        $this->slug = $slug;
        $this->event = Event::with(['images'])->active()->where('slug', $slug)->firstOrFail();
    }

    public function render()
    {
        return view('events.show', [
            'event' => $this->event,
            'moreEvents' => Event::active()->where('id', '!=', $this->event->id)->orderByDesc('id')->limit(6)->get(),
        ]);
    }
}
