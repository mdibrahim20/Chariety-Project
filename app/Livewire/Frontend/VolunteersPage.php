<?php

namespace App\Livewire\Frontend;

use App\Models\Volunteer;
use App\Models\VolunteersHeroSection;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class VolunteersPage extends Component
{
    public ?VolunteersHeroSection $hero = null;
    public $volunteers = [];

    public function mount(): void
    {
        $this->hero = VolunteersHeroSection::active()->first();
        $this->volunteers = Volunteer::active()->ordered()->get();
    }

    public function render()
    {
        return view('livewire.frontend.volunteers-page');
    }
}
