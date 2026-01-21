<?php

namespace App\Livewire\Admin\Homepage;

use App\Services\TestimonialService;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.admin')]
class Testimonials extends Component
{
    use WithFileUploads;

    protected TestimonialService $service;

    // Section Header
    public $badge_text;
    public $main_heading;
    public $sub_heading;
    public $section_is_active = true;

    // Modal state
    public $showModal = false;
    public $editMode = false;
    public $testimonialId = null;

    // Testimonial form fields
    public $rating = 5;
    public $review_text;
    public $reviewer_name;
    public $reviewer_role;
    public $avatar;
    public $existing_avatar;
    public $status = 'active';

    public function boot(TestimonialService $service): void
    {
        $this->service = $service;
    }

    public function mount(): void
    {
        $section = $this->service->getSection();

        $this->badge_text = $section->badge_text;
        $this->main_heading = $section->main_heading;
        $this->sub_heading = $section->sub_heading;
        $this->section_is_active = $section->is_active;
    }

    public function saveSection(): void
    {
        $this->validate([
            'badge_text' => 'nullable|string|max:255',
            'main_heading' => 'required|string|max:255',
            'sub_heading' => 'nullable|string',
            'section_is_active' => 'boolean',
        ]);

        $this->service->updateSection([
            'badge_text' => $this->badge_text,
            'main_heading' => $this->main_heading,
            'sub_heading' => $this->sub_heading,
            'is_active' => $this->section_is_active,
        ]);

        session()->flash('success', 'Section header updated successfully!');
    }

    public function openCreateModal(): void
    {
        $this->resetForm();
        $this->editMode = false;
        $this->showModal = true;
    }

    public function openEditModal($id): void
    {
        $testimonial = \App\Models\Testimonial::findOrFail($id);

        $this->testimonialId = $testimonial->id;
        $this->rating = $testimonial->rating;
        $this->review_text = $testimonial->review_text;
        $this->reviewer_name = $testimonial->reviewer_name;
        $this->reviewer_role = $testimonial->reviewer_role;
        $this->existing_avatar = $testimonial->avatar;
        $this->status = $testimonial->status;

        $this->editMode = true;
        $this->showModal = true;
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->resetForm();
    }

    public function save(): void
    {
        $this->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review_text' => 'required|string',
            'reviewer_name' => 'required|string|max:255',
            'reviewer_role' => 'nullable|string|max:255',
            'avatar' => $this->editMode ? 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120' : 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'status' => 'required|in:active,disabled,pending',
        ]);

        $data = [
            'rating' => $this->rating,
            'review_text' => $this->review_text,
            'reviewer_name' => $this->reviewer_name,
            'reviewer_role' => $this->reviewer_role,
            'status' => $this->status,
        ];

        if ($this->avatar) {
            $data['avatar'] = $this->avatar;
        }

        if ($this->editMode) {
            $this->service->update($this->testimonialId, $data);
            session()->flash('success', 'Testimonial updated successfully!');
        } else {
            $this->service->create($data);
            session()->flash('success', 'Testimonial created successfully!');
        }

        $this->closeModal();
    }

    public function delete($id): void
    {
        $this->service->delete($id);
        session()->flash('success', 'Testimonial deleted successfully!');
    }

    public function toggleStatus($id): void
    {
        $this->service->toggleStatus($id);
    }

    public function approve($id): void
    {
        $this->service->approve($id);
        session()->flash('success', 'Testimonial approved!');
    }

    public function removeAvatar(): void
    {
        $this->avatar = null;
    }

    private function resetForm(): void
    {
        $this->testimonialId = null;
        $this->rating = 5;
        $this->review_text = '';
        $this->reviewer_name = '';
        $this->reviewer_role = '';
        $this->avatar = null;
        $this->existing_avatar = null;
        $this->status = 'active';
    }

    public function render()
    {
        $testimonials = $this->service->getAllTestimonials();

        return view('livewire.admin.homepage.testimonials', [
            'testimonials' => $testimonials,
        ]);
    }
}
