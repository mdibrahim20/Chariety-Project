<?php

namespace App\Livewire\Admin\SiteSettings;

use App\Services\SettingsService;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin')]
class Topbar extends Component
{
    public $topbar_enabled = true;
    public $topbar_message = '';
    public $topbar_email = '';
    public $topbar_phone = '';
    public $topbar_bg_color = '#1e40af';
    public $topbar_text_color = '#ffffff';

    protected $settingsService;

    public function boot(SettingsService $settingsService)
    {
        $this->settingsService = $settingsService;
    }

    public function mount()
    {
        $this->loadSettings();
    }

    protected function loadSettings()
    {
        $this->topbar_enabled = $this->settingsService->get('topbar_enabled', true);
        $this->topbar_message = $this->settingsService->get('topbar_message', 'Are you ready for free case evaluation today?');
        $this->topbar_email = $this->settingsService->get('topbar_email', 'info@disasterrelief.com');
        $this->topbar_phone = $this->settingsService->get('topbar_phone', '(555) 123-4567');
        $this->topbar_bg_color = $this->settingsService->get('topbar_bg_color', '#1e40af');
        $this->topbar_text_color = $this->settingsService->get('topbar_text_color', '#ffffff');
    }

    protected function rules()
    {
        return [
            'topbar_enabled' => 'boolean',
            'topbar_message' => 'nullable|string|max:255',
            'topbar_email' => 'nullable|email|max:255',
            'topbar_phone' => 'nullable|string|max:50',
            'topbar_bg_color' => 'nullable|string|max:7',
            'topbar_text_color' => 'nullable|string|max:7',
        ];
    }

    public function save()
    {
        $this->validate();

        try {
            $this->settingsService->setMultiple([
                'topbar_enabled' => $this->topbar_enabled,
                'topbar_message' => $this->topbar_message,
                'topbar_email' => $this->topbar_email,
                'topbar_phone' => $this->topbar_phone,
                'topbar_bg_color' => $this->topbar_bg_color,
                'topbar_text_color' => $this->topbar_text_color,
            ], 'topbar');

            session()->flash('success', 'Topbar settings saved successfully.');
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to save settings: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.admin.site-settings.topbar');
    }
}
