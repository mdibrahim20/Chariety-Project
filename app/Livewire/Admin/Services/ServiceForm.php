<?php

namespace App\Livewire\Admin\Services;

use App\Models\Service;
use App\Services\ServicesService;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.admin')]
class ServiceForm extends Component
{
    use WithFileUploads;

    protected ServicesService $service;

    public ?Service $serviceModel = null;
    public $title;
    public $slug;
    public $short_description;
    public $icon;
    public $icon_class;
    public $use_icon_upload = true; // Toggle between upload and class
    public $existing_icon;
    public $card_image;
    public $existing_card_image;
    public $button_text = 'Read More';
    public $button_link;
    public $is_active = true;
    public $is_featured = false;
    public $display_order = 0;

    public function boot(ServicesService $service): void
    {
        $this->service = $service;
    }

    public function mount($id = null): void
    {
        if ($id) {
            $this->serviceModel = Service::findOrFail($id);
            $this->title = $this->serviceModel->title;
            $this->slug = $this->serviceModel->slug;
            $this->short_description = $this->serviceModel->short_description;
            $this->existing_icon = $this->serviceModel->icon;
            $this->existing_card_image = $this->serviceModel->card_image;
            $this->button_text = $this->serviceModel->button_text;
            $this->button_link = $this->serviceModel->button_link;
            $this->is_active = $this->serviceModel->is_active;
            $this->is_featured = $this->serviceModel->is_featured;
            $this->display_order = $this->serviceModel->display_order;
            
            // Determine if existing icon is a file or class
            if ($this->existing_icon && str_starts_with($this->existing_icon, 'services/')) {
                $this->use_icon_upload = true;
            } else {
                $this->use_icon_upload = false;
                $this->icon_class = $this->existing_icon;
            }
        }
    }

    public function updatedTitle()
    {
        if (!$this->serviceModel) {
            $this->slug = \Str::slug($this->title);
        }
    }

    public function save()
    {
        try {
            $this->validate([
                'title' => 'required|string|max:255',
                'slug' => 'required|string|max:255|unique:services,slug,' . ($this->serviceModel->id ?? 'NULL'),
                'short_description' => 'nullable|string',
                'icon' => 'nullable|image|mimes:svg,png,jpg,jpeg|max:2048',
                'icon_class' => 'nullable|string|max:255',
                'card_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
                'button_text' => 'nullable|string|max:255',
                'button_link' => 'nullable|string|max:500',
                'display_order' => 'integer|min:0',
            ]);

            $data = [
                'title' => $this->title,
                'slug' => $this->slug,
                'short_description' => $this->short_description,
                'button_text' => $this->button_text,
                'button_link' => $this->button_link,
                'is_active' => (bool) $this->is_active,
                'is_featured' => (bool) $this->is_featured,
                'display_order' => (int) $this->display_order,
            ];

            // Handle icon
            if ($this->use_icon_upload && $this->icon) {
                $data['icon'] = $this->icon;
            } elseif (!$this->use_icon_upload && $this->icon_class) {
                $data['icon_class'] = $this->icon_class;
            }

            // Handle card image
            if ($this->card_image) {
                $data['card_image'] = $this->card_image;
            }

            $savedService = $this->service->upsertService($data, $this->serviceModel);

            session()->flash('success', 'Service saved successfully!');
            $this->redirect(route('admin.services.edit', $savedService->id));
        } catch (\Exception $e) {
            \Log::error('Service save error: ' . $e->getMessage());
            session()->flash('error', 'Failed to save: ' . $e->getMessage());
        }
    }

    public function removeIcon(): void
    {
        $this->icon = null;
    }

    public function removeCardImage(): void
    {
        $this->card_image = null;
    }

    public function deleteIcon(): void
    {
        if ($this->serviceModel && $this->existing_icon) {
            \Storage::delete($this->existing_icon);
            $this->serviceModel->update(['icon' => null]);
            $this->existing_icon = null;
            session()->flash('success', 'Icon deleted!');
        }
    }

    public function deleteCardImage(): void
    {
        if ($this->serviceModel && $this->existing_card_image) {
            \Storage::delete($this->existing_card_image);
            $this->serviceModel->update(['card_image' => null]);
            $this->existing_card_image = null;
            session()->flash('success', 'Card image deleted!');
        }
    }

    public function render()
    {
        return view('livewire.admin.services.service-form');
    }
}
