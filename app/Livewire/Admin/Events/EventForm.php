<?php

namespace App\Livewire\Admin\Events;

use App\Models\Event;
use App\Models\EventImage;
use App\Services\EventService;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.admin')]
class EventForm extends Component
{
    use WithFileUploads;

    protected EventService $service;

    public ?Event $event = null;

    public $title;
    public $slug;
    public $summary;
    public $content_html;
    public $is_active = true;
    public $ordering = 0;

    public $meta_title;
    public $meta_description;
    public $meta_image; // upload
    public $existing_meta_image;

    public $gallery = []; // uploads

    public function boot(EventService $service) { $this->service = $service; }

    public function mount(?int $eventId = null)
    {
        if ($eventId) {
            $this->event = Event::with('images')->findOrFail($eventId);
            $this->fill([
                'title' => $this->event->title,
                'slug' => $this->event->slug,
                'summary' => $this->event->summary,
                'content_html' => $this->event->content_html,
                'is_active' => $this->event->is_active,
                'ordering' => $this->event->ordering,
                'meta_title' => $this->event->meta_title,
                'meta_description' => $this->event->meta_description,
                'existing_meta_image' => $this->event->meta_image,
            ]);
        }
    }

    public function save()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'summary' => 'nullable|string|max:500',
            'content_html' => 'nullable|string',
            'ordering' => 'integer|min:0',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:255',
            'meta_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:10240',
            'gallery.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:10240',
        ]);

        $data = [
            'title' => $this->title,
            'slug' => $this->slug,
            'summary' => $this->summary,
            'content_html' => $this->content_html,
            'is_active' => (bool) $this->is_active,
            'ordering' => (int) $this->ordering,
            'meta_title' => $this->meta_title,
            'meta_description' => $this->meta_description,
        ];

        // Meta image
        if ($this->meta_image) {
            // Process meta image to thumbnail size
            [$featured, $thumb] = $this->service->addGalleryImagesPlaceholderProcess($this->meta_image);
            $data['meta_image'] = $thumb; // store small version for meta
        }

        $event = $this->service->upsertEvent($data, $this->event);
        $this->event = $event;

        // Gallery images
        if (!empty($this->gallery)) {
            $this->service->addGalleryImages($event, $this->gallery);
            $this->reset(['gallery']);
        }

        session()->flash('success', 'Event saved successfully');
        return redirect()->route('admin.events.index');
    }

    public function setFeatured($imageId)
    {
        $this->service->setFeaturedImage($this->event, (int)$imageId);
        $this->event->refresh();
    }

    public function deleteImage($imageId)
    {
        $image = EventImage::findOrFail($imageId);
        $this->service->deleteImage($image);
        $this->event->refresh();
    }

    public function render()
    {
        return view('livewire.admin.events.form', [
            'event' => $this->event,
            'images' => $this->event ? $this->event->images : collect(),
        ]);
    }
}
