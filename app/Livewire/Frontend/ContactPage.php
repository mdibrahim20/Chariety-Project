<?php

namespace App\Livewire\Frontend;

use App\Models\ContactHeroSection;
use App\Models\ContactSetting;
use App\Services\ContactService;
use Livewire\Component;

class ContactPage extends Component
{
    public $first_name;
    public $last_name;
    public $email;
    public $amount;
    public $subject;
    public $message;

    protected $rules = [
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'amount' => 'nullable|numeric|min:0',
        'subject' => 'nullable|string|max:255',
        'message' => 'required|string',
    ];

    public function submit(ContactService $service)
    {
        $this->validate();

        try {
            $service->submitContactForm([
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'email' => $this->email,
                'amount' => $this->amount,
                'subject' => $this->subject,
                'message' => $this->message,
            ]);

            session()->flash('success', 'Thank you! Your message has been sent successfully.');
            
            $this->reset(['first_name', 'last_name', 'email', 'amount', 'subject', 'message']);
        } catch (\Exception $e) {
            session()->flash('error', 'Something went wrong. Please try again.');
        }
    }

    public function render()
    {
        $hero = ContactHeroSection::active()->first();
        $settings = ContactSetting::first();

        return view('livewire.frontend.contact-page', [
            'hero' => $hero,
            'settings' => $settings,
        ])->layout('layouts.guest');
    }
}
