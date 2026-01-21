<?php

namespace App\Livewire\Admin\Volunteers;

use App\Models\Volunteer;
use App\Services\VolunteersService;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.admin')]
class VolunteerForm extends Component
{
    use WithFileUploads;

    protected VolunteersService $service;

    public ?Volunteer $volunteer = null;
    public $name;
    public $designation;
    public $profile_photo;
    public $existing_profile_photo;
    public $facebook_url;
    public $instagram_url;
    public $twitter_url;
    public $linkedin_url;
    public $is_active = true;
    public $display_order = 0;

    public function boot(VolunteersService $service): void
    {
        $this->service = $service;
    }

    public function mount($id = null): void
    {
        if ($id) {
            $this->volunteer = Volunteer::findOrFail($id);
            $this->name = $this->volunteer->name;
            $this->designation = $this->volunteer->designation;
            $this->existing_profile_photo = $this->volunteer->profile_photo;
            $this->facebook_url = $this->volunteer->facebook_url;
            $this->instagram_url = $this->volunteer->instagram_url;
            $this->twitter_url = $this->volunteer->twitter_url;
            $this->linkedin_url = $this->volunteer->linkedin_url;
            $this->is_active = $this->volunteer->is_active;
            $this->display_order = $this->volunteer->display_order;
        }
    }

    public function save()
    {
        try {
            $this->validate([
                'name' => 'required|string|max:255',
                'designation' => 'nullable|string|max:255',
                'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
                'facebook_url' => 'nullable|url|max:500',
                'instagram_url' => 'nullable|url|max:500',
                'twitter_url' => 'nullable|url|max:500',
                'linkedin_url' => 'nullable|url|max:500',
                'display_order' => 'integer|min:0',
            ]);

            $data = [
                'name' => $this->name,
                'designation' => $this->designation,
                'facebook_url' => $this->facebook_url,
                'instagram_url' => $this->instagram_url,
                'twitter_url' => $this->twitter_url,
                'linkedin_url' => $this->linkedin_url,
                'is_active' => (bool) $this->is_active,
                'display_order' => (int) $this->display_order,
            ];

            if ($this->profile_photo) {
                $data['profile_photo'] = $this->profile_photo;
            }

            $savedVolunteer = $this->service->upsertVolunteer($data, $this->volunteer);

            session()->flash('success', 'Volunteer saved successfully!');
            $this->redirect(route('admin.volunteers.edit', $savedVolunteer->id));
        } catch (\Exception $e) {
            \Log::error('Volunteer save error: ' . $e->getMessage());
            session()->flash('error', 'Failed to save: ' . $e->getMessage());
        }
    }

    public function removeProfilePhoto(): void
    {
        $this->profile_photo = null;
    }

    public function deleteProfilePhoto(): void
    {
        if ($this->volunteer && $this->existing_profile_photo) {
            \Storage::delete($this->existing_profile_photo);
            $this->volunteer->update(['profile_photo' => null]);
            $this->existing_profile_photo = null;
            session()->flash('success', 'Profile photo deleted!');
        }
    }

    public function render()
    {
        return view('livewire.admin.volunteers.volunteer-form');
    }
}
