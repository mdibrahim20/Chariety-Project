<?php

namespace App\Livewire\Admin\Contact;

use App\Services\ContactHeroService;
use Livewire\Component;
use Livewire\WithFileUploads;

class ContactHero extends Component
{
    use WithFileUploads;

    public $page_title;
    public $breadcrumb_home_label;
    public $breadcrumb_current_label;
    public $background_image;
    public $current_background_image;
    public $is_active;
    public $overlay_enabled;
    public $overlay_opacity;

    protected $rules = [
        'page_title' => 'required|string|max:255',
        'breadcrumb_home_label' => 'required|string|max:100',
        'breadcrumb_current_label' => 'required|string|max:100',
        'background_image' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:10240',
        'is_active' => 'boolean',
        'overlay_enabled' => 'boolean',
        'overlay_opacity' => 'required|integer|min:0|max:100',
    ];

    public function mount(ContactHeroService $service)
    {
        $section = $service->getSection();
        
        $this->page_title = $section->page_title;
        $this->breadcrumb_home_label = $section->breadcrumb_home_label;
        $this->breadcrumb_current_label = $section->breadcrumb_current_label;
        $this->current_background_image = $section->background_image;
        $this->is_active = $section->is_active;
        $this->overlay_enabled = $section->overlay_enabled;
        $this->overlay_opacity = $section->overlay_opacity;
    }

    public function save(ContactHeroService $service)
    {
        $this->validate();

        $data = [
            'page_title' => $this->page_title,
            'breadcrumb_home_label' => $this->breadcrumb_home_label,
            'breadcrumb_current_label' => $this->breadcrumb_current_label,
            'is_active' => $this->is_active ?? false,
            'overlay_enabled' => $this->overlay_enabled ?? false,
            'overlay_opacity' => $this->overlay_opacity,
        ];

        if ($this->background_image) {
            $data['background_image'] = $this->background_image;
        }

        $service->updateSection($data);
        
        session()->flash('success', 'Contact Hero section updated successfully!');
        $this->redirect('/admin/contact/hero', navigate: true);
    }

    public function deleteImage(ContactHeroService $service)
    {
        $service->deleteBackgroundImage();
        $this->current_background_image = null;
        session()->flash('success', 'Background image deleted successfully!');
    }

    public function render()
    {
        return view('livewire.admin.contact.contact-hero')
            ->layout('layouts.admin');
    }
}
