<?php

namespace App\Livewire\Admin\Settings;

use App\Services\SettingsService;
use Livewire\Component;

class Appearance extends Component
{
    public string $primary_color = '#3B82F6';
    public bool $sidebar_collapsed_default = false;

    public function mount(SettingsService $settings)
    {
        $this->primary_color = $settings->get('primary_color', '#3B82F6');
        $this->sidebar_collapsed_default = $settings->get('sidebar_collapsed_default', false);
    }

    public function save(SettingsService $settings)
    {
        $settings->setMultiple([
            'primary_color' => $this->primary_color,
            'sidebar_collapsed_default' => $this->sidebar_collapsed_default,
        ], 'appearance');

        session()->flash('success', 'Appearance settings saved successfully.');
    }

    public function render()
    {
        return view('livewire.admin.settings.appearance')->layout('layouts.admin');
    }
}
