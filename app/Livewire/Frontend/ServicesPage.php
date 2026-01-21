<?php

namespace App\Livewire\Frontend;

use App\Models\Service;
use App\Models\ServicesHeroSection;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class ServicesPage extends Component
{
    public ?ServicesHeroSection $hero = null;
    public $services = [];

    public function mount(): void
    {
        $this->hero = ServicesHeroSection::active()->first();
        $this->services = Service::active()->ordered()->get();
    }

    public function render()
    {
        return view('livewire.frontend.services-page');
    }
}
