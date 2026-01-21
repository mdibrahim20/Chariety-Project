<?php

namespace App\Livewire\Admin\Homepage;

use App\Models\HeroSlide;
use App\Services\HeroSlideService;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.admin')]
class HeroSection extends Component
{
    use WithFileUploads;

    public $slides = [];
    public $showModal = false;
    public $editMode = false;
    public $slideId = null;

    // Form fields
    public $sub_heading = '';
    public $heading = '';
    public $sub_heading_2 = '';
    public $image;
    public $existing_image = null;
    public $is_active = true;

    protected $heroSlideService;

    public function boot(HeroSlideService $heroSlideService)
    {
        $this->heroSlideService = $heroSlideService;
    }

    public function mount()
    {
        $this->loadSlides();
    }

    protected function loadSlides()
    {
        $this->slides = $this->heroSlideService->getAll();
    }

    public function openCreateModal()
    {
        $this->resetForm();
        $this->editMode = false;
        $this->showModal = true;
    }

    public function openEditModal($id)
    {
        $slide = HeroSlide::findOrFail($id);

        $this->slideId = $slide->id;
        $this->sub_heading = $slide->sub_heading ?? '';
        $this->heading = $slide->heading;
        $this->sub_heading_2 = $slide->sub_heading_2 ?? '';
        $this->existing_image = $slide->image;
        $this->is_active = $slide->is_active;

        $this->editMode = true;
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
        $this->resetValidation();
    }

    protected function resetForm()
    {
        $this->slideId = null;
        $this->sub_heading = '';
        $this->heading = '';
        $this->sub_heading_2 = '';
        $this->image = null;
        $this->existing_image = null;
        $this->is_active = true;
    }

    protected function rules()
    {
        $rules = [
            'sub_heading' => 'nullable|string|max:255',
            'heading' => 'required|string|max:255',
            'sub_heading_2' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ];

        if ($this->editMode) {
            $rules['image'] = 'nullable|image|mimes:jpg,jpeg,png,webp|max:10240';
        } else {
            $rules['image'] = 'required|image|mimes:jpg,jpeg,png,webp|max:10240';
        }

        return $rules;
    }

    protected $messages = [
        'image.required' => 'Please upload a slide image.',
        'image.image' => 'The file must be an image.',
        'image.mimes' => 'Only JPG, JPEG, PNG, and WEBP images are allowed.',
        'image.max' => 'Image size must not exceed 10MB.',
    ];

    public function save()
    {
        $this->validate();

        try {
            $data = [
                'sub_heading' => $this->sub_heading,
                'heading' => $this->heading,
                'sub_heading_2' => $this->sub_heading_2,
                'is_active' => $this->is_active,
            ];

            if ($this->image) {
                $data['image'] = $this->image;
            }

            if ($this->editMode) {
                $slide = HeroSlide::findOrFail($this->slideId);
                $this->heroSlideService->update($slide, $data);
                session()->flash('success', 'Hero slide updated successfully.');
            } else {
                $this->heroSlideService->create($data);
                session()->flash('success', 'Hero slide created successfully.');
            }

            $this->closeModal();
            $this->loadSlides();
        } catch (\Exception $e) {
            session()->flash('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function delete($id)
    {
        $slide = HeroSlide::findOrFail($id);
        $this->heroSlideService->delete($slide);

        session()->flash('success', 'Hero slide deleted successfully.');
        $this->loadSlides();
    }

    public function toggleStatus($id)
    {
        $slide = HeroSlide::findOrFail($id);
        $this->heroSlideService->toggleStatus($slide);

        session()->flash('success', 'Slide status updated.');
        $this->loadSlides();
    }

    public function updateOrder($orderedIds)
    {
        $this->heroSlideService->reorder($orderedIds);

        session()->flash('success', 'Slide order updated.');
        $this->loadSlides();
    }

    public function render()
    {
        return view('livewire.admin.homepage.hero-section');
    }
}
