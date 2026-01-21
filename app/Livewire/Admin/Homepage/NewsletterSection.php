<?php

namespace App\Livewire\Admin\Homepage;

use App\Services\NewsletterService;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.admin')]
class NewsletterSection extends Component
{
    use WithFileUploads;

    protected NewsletterService $service;

    public $heading_text;
    public $description_text;
    public $email_placeholder;
    public $button_text;
    public $success_message;
    public $error_message;
    public $background_image;
    public $existing_background_image;
    public $is_active = true;
    public $overlay_enabled = true;
    public $overlay_opacity = 50;

    public function boot(NewsletterService $service): void
    {
        $this->service = $service;
    }

    public function mount(): void
    {
        $section = $this->service->getSection();

        $this->heading_text = $section->heading_text;
        $this->description_text = $section->description_text;
        $this->email_placeholder = $section->email_placeholder;
        $this->button_text = $section->button_text;
        $this->success_message = $section->success_message;
        $this->error_message = $section->error_message;
        $this->existing_background_image = $section->background_image;
        $this->is_active = $section->is_active;
        $this->overlay_enabled = $section->overlay_enabled;
        $this->overlay_opacity = $section->overlay_opacity;
    }

    public function save(): void
    {
        try {
            $validated = $this->validate([
                'heading_text' => 'required|string|max:255',
                'description_text' => 'nullable|string',
                'email_placeholder' => 'nullable|string|max:255',
                'button_text' => 'nullable|string|max:255',
                'success_message' => 'nullable|string|max:255',
                'error_message' => 'nullable|string|max:255',
                'background_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:10240',
                'overlay_opacity' => 'integer|min:0|max:100',
            ]);

            $data = [
                'heading_text' => $this->heading_text,
                'description_text' => $this->description_text,
                'email_placeholder' => $this->email_placeholder,
                'button_text' => $this->button_text,
                'success_message' => $this->success_message,
                'error_message' => $this->error_message,
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
            $this->heading_text = $section->heading_text;
            $this->description_text = $section->description_text;
            $this->email_placeholder = $section->email_placeholder;
            $this->button_text = $section->button_text;
            $this->success_message = $section->success_message;
            $this->error_message = $section->error_message;
            $this->existing_background_image = $section->background_image;
            $this->is_active = $section->is_active;
            $this->overlay_enabled = $section->overlay_enabled;
            $this->overlay_opacity = $section->overlay_opacity;

            session()->flash('success', 'Newsletter section updated successfully!');
            
            $this->dispatch('sectionUpdated');
        } catch (\Exception $e) {
            \Log::error('Newsletter section save error: ' . $e->getMessage());
            session()->flash('error', 'Failed to update newsletter section: ' . $e->getMessage());
        }
    }

    public function removeBackgroundImage(): void
    {
        $this->background_image = null;
    }

    public function render()
    {
        return view('livewire.admin.homepage.newsletter-section');
    }
}
