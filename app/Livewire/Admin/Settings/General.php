<?php

namespace App\Livewire\Admin\Settings;

use App\Services\SettingsService;
use Livewire\Component;

class General extends Component
{
    public string $app_name = '';
    public string $app_timezone = '';
    public string $app_locale = '';

    protected $rules = [
        'app_name' => 'required|string|max:255',
        'app_timezone' => 'required|string',
        'app_locale' => 'required|string',
    ];

    public function mount(SettingsService $settings)
    {
        $this->app_name = $settings->get('app_name', config('app.name'));
        $this->app_timezone = $settings->get('app_timezone', config('app.timezone'));
        $this->app_locale = $settings->get('app_locale', config('app.locale'));
    }

    public function save(SettingsService $settings)
    {
        $this->validate();

        $settings->setMultiple([
            'app_name' => $this->app_name,
            'app_timezone' => $this->app_timezone,
            'app_locale' => $this->app_locale,
        ], 'general');

        session()->flash('success', 'General settings saved successfully.');
    }

    public function render()
    {
        return view('livewire.admin.settings.general')->layout('layouts.admin');
    }
}
