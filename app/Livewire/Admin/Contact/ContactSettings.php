<?php

namespace App\Livewire\Admin\Contact;

use App\Services\ContactService;
use Livewire\Component;

class ContactSettings extends Component
{
    public $badge_label;
    public $main_heading;
    public $description;
    public $submit_button_text;
    public $google_map_embed;
    public $subject_options;
    
    // Phone Card
    public $card_phone_enabled;
    public $card_phone_title;
    public $card_phone_subtitle;
    public $card_phone_1;
    public $card_phone_2;
    
    // Email Card
    public $card_email_enabled;
    public $card_email_title;
    public $card_email_subtitle;
    public $card_email_1;
    public $card_email_2;
    
    // Location Card
    public $card_location_enabled;
    public $card_location_title;
    public $card_location_subtitle;
    public $card_location_address;

    protected $rules = [
        'badge_label' => 'nullable|string|max:255',
        'main_heading' => 'required|string|max:255',
        'description' => 'nullable|string',
        'submit_button_text' => 'required|string|max:100',
        'google_map_embed' => 'nullable|string',
        'subject_options' => 'nullable|string',
        'card_phone_enabled' => 'boolean',
        'card_phone_title' => 'nullable|string|max:255',
        'card_phone_subtitle' => 'nullable|string|max:255',
        'card_phone_1' => 'nullable|string|max:50',
        'card_phone_2' => 'nullable|string|max:50',
        'card_email_enabled' => 'boolean',
        'card_email_title' => 'nullable|string|max:255',
        'card_email_subtitle' => 'nullable|string|max:255',
        'card_email_1' => 'nullable|email|max:255',
        'card_email_2' => 'nullable|email|max:255',
        'card_location_enabled' => 'boolean',
        'card_location_title' => 'nullable|string|max:255',
        'card_location_subtitle' => 'nullable|string|max:255',
        'card_location_address' => 'nullable|string',
    ];

    public function mount(ContactService $service)
    {
        $settings = $service->getSettings();
        
        $this->badge_label = $settings->badge_label;
        $this->main_heading = $settings->main_heading;
        $this->description = $settings->description;
        $this->submit_button_text = $settings->submit_button_text;
        $this->google_map_embed = $settings->google_map_embed;
        $this->subject_options = $settings->subject_options;
        
        $this->card_phone_enabled = $settings->card_phone_enabled;
        $this->card_phone_title = $settings->card_phone_title;
        $this->card_phone_subtitle = $settings->card_phone_subtitle;
        $this->card_phone_1 = $settings->card_phone_1;
        $this->card_phone_2 = $settings->card_phone_2;
        
        $this->card_email_enabled = $settings->card_email_enabled;
        $this->card_email_title = $settings->card_email_title;
        $this->card_email_subtitle = $settings->card_email_subtitle;
        $this->card_email_1 = $settings->card_email_1;
        $this->card_email_2 = $settings->card_email_2;
        
        $this->card_location_enabled = $settings->card_location_enabled;
        $this->card_location_title = $settings->card_location_title;
        $this->card_location_subtitle = $settings->card_location_subtitle;
        $this->card_location_address = $settings->card_location_address;
    }

    public function save(ContactService $service)
    {
        $this->validate();

        $service->updateSettings([
            'badge_label' => $this->badge_label,
            'main_heading' => $this->main_heading,
            'description' => $this->description,
            'submit_button_text' => $this->submit_button_text,
            'google_map_embed' => $this->google_map_embed,
            'subject_options' => $this->subject_options,
            'card_phone_enabled' => $this->card_phone_enabled ?? false,
            'card_phone_title' => $this->card_phone_title,
            'card_phone_subtitle' => $this->card_phone_subtitle,
            'card_phone_1' => $this->card_phone_1,
            'card_phone_2' => $this->card_phone_2,
            'card_email_enabled' => $this->card_email_enabled ?? false,
            'card_email_title' => $this->card_email_title,
            'card_email_subtitle' => $this->card_email_subtitle,
            'card_email_1' => $this->card_email_1,
            'card_email_2' => $this->card_email_2,
            'card_location_enabled' => $this->card_location_enabled ?? false,
            'card_location_title' => $this->card_location_title,
            'card_location_subtitle' => $this->card_location_subtitle,
            'card_location_address' => $this->card_location_address,
        ]);

        session()->flash('success', 'Contact Settings updated successfully!');
        $this->redirect('/admin/contact/settings', navigate: true);
    }

    public function render()
    {
        return view('livewire.admin.contact.contact-settings')
            ->layout('layouts.admin');
    }
}
