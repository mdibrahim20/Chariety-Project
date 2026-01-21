<?php

namespace App\Livewire\Admin\Faq;

use App\Services\FaqService;
use Livewire\Component;

class FaqSettings extends Component
{
    public $section_heading;

    protected $rules = [
        'section_heading' => 'required|string|max:255',
    ];

    public function mount(FaqService $service)
    {
        $settings = $service->getSettings();
        $this->section_heading = $settings->section_heading;
    }

    public function save(FaqService $service)
    {
        $this->validate();

        $service->updateSettings([
            'section_heading' => $this->section_heading,
        ]);

        session()->flash('success', 'FAQ Settings updated successfully!');
        $this->redirect('/admin/faq/settings', navigate: true);
    }

    public function render()
    {
        return view('livewire.admin.faq.faq-settings')
            ->layout('layouts.app');
    }
}
