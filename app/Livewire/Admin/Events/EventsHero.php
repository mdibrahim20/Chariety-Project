<?php

namespace App\Livewire\Admin\Events;

use App\Services\EventsHeroService;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.admin')]
class EventsHero extends Component
{
    use WithFileUploads;

    protected EventsHeroService $service;

    public $page_title;
    public $breadcrumb_home_label;
    public $breadcrumb_current_page_label;
    public $background_image;
    public $existing_background_image;
    public $is_active = true;
    public $overlay_enabled = true;
    public $overlay_opacity = 50;

    public function boot(EventsHeroService $service): void
    {
        $this->service = $service;
    }

    public function mount(): void
    {
        $section = $this->service->getSection();

        $this->page_title = $section->page_title;
        $this->breadcrumb_home_label = $section->breadcrumb_home_label;
        $this->breadcrumb_current_page_label = $section->breadcrumb_current_page_label;
        $this->existing_background_image = $section->background_image;
        $this->is_active = $section->is_active;
        $this->overlay_enabled = $section->overlay_enabled;
        $this->overlay_opacity = $section->overlay_opacity;
    }

    public function save(): void
    {
        try {
            $validated = $this->validate([
                'page_title' => 'required|string|max:255',
                'breadcrumb_home_label' => 'nullable|string|max:255',
                'breadcrumb_current_page_label' => 'nullable|string|max:255',
                'background_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:10240',
                'overlay_opacity' => 'integer|min:0|max:100',
            ]);

            $data = [
                'page_title' => $this->page_title,
                'breadcrumb_home_label' => $this->breadcrumb_home_label,
                'breadcrumb_current_page_label' => $this->breadcrumb_current_page_label,
                'is_active' => (bool) $this->is_active,
                'overlay_enabled' => (bool) $this->overlay_enabled,
                'overlay_opacity' => (int) $this->overlay_opacity,
            ];

            if ($this->background_image) {
                $data['background_image'] = $this->background_image;
            }

            $section = $this->service->updateSection($data);

            // Reset temporary file upload
            $this->reset(['background_image']);

            // Reload the section data
            $this->page_title = $section->page_title;
            $this->breadcrumb_home_label = $section->breadcrumb_home_label;
            $this->breadcrumb_current_page_label = $section->breadcrumb_current_page_label;
            $this->existing_background_image = $section->background_image;
            $this->is_active = $section->is_active;
            $this->overlay_enabled = $section->overlay_enabled;
            $this->overlay_opacity = $section->overlay_opacity;

            session()->flash('success', 'Events hero section updated successfully!');
            
            $this->dispatch('sectionUpdated');
        } catch (\Exception $e) {
            \Log::error('Events hero section save error: ' . $e->getMessage());
            session()->flash('error', 'Failed to update events hero section: ' . $e->getMessage());
        }
    }

    public function removeBackgroundImage(): void
    {
        $this->background_image = null;
    }

    public function deleteBackgroundImage(): void
    {
        try {
            $this->service->deleteBackgroundImage();
            $this->existing_background_image = null;
            session()->flash('success', 'Background image deleted successfully!');
        } catch (\Exception $e) {
            \Log::error('Events hero delete image error: ' . $e->getMessage());
            session()->flash('error', 'Failed to delete background image: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.admin.events.events-hero');
    }
}
