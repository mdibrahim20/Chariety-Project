<?php

namespace App\Livewire;

use App\Models\Event;
use App\Services\DonationService;
use Livewire\Component;

class DonationWidget extends Component
{
    public ?int $eventId = null;
    public $amount;
    public $full_name;
    public $email;
    public $phone;
    public $payment_method = 'bkash';

    protected DonationService $service;

    public function boot(DonationService $service) { $this->service = $service; }

    public function submit()
    {
        $this->validate([
            'amount' => 'required|numeric|min:1',
            'full_name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:30',
            'payment_method' => 'required|in:bkash,nagad,bank,check',
        ]);

        $event = null;
        if ($this->eventId) {
            $event = Event::find($this->eventId);
        }

        $donation = $this->service->submit([
            'amount' => (int)$this->amount,
            'full_name' => $this->full_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'payment_method' => $this->payment_method,
        ], $event);

        session()->flash('success', 'Thank you! Your donation has been recorded.');
        $this->reset(['amount','full_name','email','phone','payment_method']);
    }

    public function render()
    {
        return view('livewire.donation-widget');
    }
}
