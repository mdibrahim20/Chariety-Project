<?php

namespace App\Livewire\Admin\Homepage;

use App\Services\AboutUsSectionService;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.admin')]
class AboutUsSection extends Component
{
    use WithFileUploads;

    protected AboutUsSectionService $service;

    // Left Content
    public $badge_text;
    public $main_heading;
    public $description;

    // Feature Card 1
    public $feature1_icon;
    public $existing_feature1_icon;
    public $feature1_title;
    public $feature1_description;

    // Feature Card 2
    public $feature2_icon;
    public $existing_feature2_icon;
    public $feature2_title;
    public $feature2_description;

    // Right Content
    public $right_paragraph;
    public $cta_button_text;
    public $cta_button_link;
    public $cta_button_target = '_self';

    // Images
    public $image1;
    public $existing_image1;
    public $image2;
    public $existing_image2;

    // Status
    public $is_active = true;

    public function boot(AboutUsSectionService $service): void
    {
        $this->service = $service;
    }

    public function mount(): void
    {
        $section = $this->service->getSection();

        $this->badge_text = $section->badge_text;
        $this->main_heading = $section->main_heading;
        $this->description = $section->description;

        $this->existing_feature1_icon = $section->feature1_icon;
        $this->feature1_title = $section->feature1_title;
        $this->feature1_description = $section->feature1_description;

        $this->existing_feature2_icon = $section->feature2_icon;
        $this->feature2_title = $section->feature2_title;
        $this->feature2_description = $section->feature2_description;

        $this->right_paragraph = $section->right_paragraph;
        $this->cta_button_text = $section->cta_button_text;
        $this->cta_button_link = $section->cta_button_link;
        $this->cta_button_target = $section->cta_button_target;

        $this->existing_image1 = $section->image1;
        $this->existing_image2 = $section->image2;

        $this->is_active = $section->is_active;
    }

    public function save(): void
    {
        $this->validate([
            'main_heading' => 'required|string|max:255',
            'badge_text' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            
            'feature1_icon' => 'nullable|file|mimes:svg,jpg,jpeg,png,webp|max:2048',
            'feature1_title' => 'nullable|string|max:255',
            'feature1_description' => 'nullable|string',
            
            'feature2_icon' => 'nullable|file|mimes:svg,jpg,jpeg,png,webp|max:2048',
            'feature2_title' => 'nullable|string|max:255',
            'feature2_description' => 'nullable|string',
            
            'right_paragraph' => 'nullable|string',
            'cta_button_text' => 'nullable|string|max:255',
            'cta_button_link' => 'nullable|url|max:255',
            'cta_button_target' => 'nullable|in:_self,_blank',
            
            'image1' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:10240',
            'image2' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:10240',
            
            'is_active' => 'boolean',
        ]);

        $data = [
            'badge_text' => $this->badge_text,
            'main_heading' => $this->main_heading,
            'description' => $this->description,
            
            'feature1_title' => $this->feature1_title,
            'feature1_description' => $this->feature1_description,
            
            'feature2_title' => $this->feature2_title,
            'feature2_description' => $this->feature2_description,
            
            'right_paragraph' => $this->right_paragraph,
            'cta_button_text' => $this->cta_button_text,
            'cta_button_link' => $this->cta_button_link,
            'cta_button_target' => $this->cta_button_target,
            
            'is_active' => $this->is_active,
        ];

        // Add uploaded files to data
        if ($this->feature1_icon) {
            $data['feature1_icon'] = $this->feature1_icon;
        }
        if ($this->feature2_icon) {
            $data['feature2_icon'] = $this->feature2_icon;
        }
        if ($this->image1) {
            $data['image1'] = $this->image1;
        }
        if ($this->image2) {
            $data['image2'] = $this->image2;
        }

        $this->service->update($data);

        // Reset temporary file uploads
        $this->reset(['feature1_icon', 'feature2_icon', 'image1', 'image2']);

        // Reload the section data
        $this->mount();

        session()->flash('success', 'About Us section updated successfully!');
    }

    public function removeFeature1Icon(): void
    {
        $this->feature1_icon = null;
    }

    public function removeFeature2Icon(): void
    {
        $this->feature2_icon = null;
    }

    public function removeImage1(): void
    {
        $this->image1 = null;
    }

    public function removeImage2(): void
    {
        $this->image2 = null;
    }

    public function render()
    {
        return view('livewire.admin.homepage.about-us-section');
    }
}
