<?php

namespace App\Livewire\Admin\Settings;

use App\Models\LoginActivity;
use App\Services\SettingsService;
use Livewire\Component;
use Livewire\WithPagination;

class Security extends Component
{
    use WithPagination;

    public bool $force_2fa_for_admins = false;
    public int $password_min_length = 8;
    public bool $password_require_uppercase = true;
    public bool $password_require_numbers = true;
    public bool $password_require_special = false;
    public int $session_timeout = 120;

    public function mount(SettingsService $settings)
    {
        $this->force_2fa_for_admins = $settings->get('force_2fa_for_admins', false);
        $this->password_min_length = $settings->get('password_min_length', 8);
        $this->password_require_uppercase = $settings->get('password_require_uppercase', true);
        $this->password_require_numbers = $settings->get('password_require_numbers', true);
        $this->password_require_special = $settings->get('password_require_special', false);
        $this->session_timeout = $settings->get('session_timeout', 120);
    }

    public function save(SettingsService $settings)
    {
        $settings->setMultiple([
            'force_2fa_for_admins' => $this->force_2fa_for_admins,
            'password_min_length' => $this->password_min_length,
            'password_require_uppercase' => $this->password_require_uppercase,
            'password_require_numbers' => $this->password_require_numbers,
            'password_require_special' => $this->password_require_special,
            'session_timeout' => $this->session_timeout,
        ], 'security');

        session()->flash('success', 'Security settings saved successfully.');
    }

    public function render()
    {
        $recentLogins = LoginActivity::with('user')
            ->latest()
            ->paginate(20);

        return view('livewire.admin.settings.security', [
            'recentLogins' => $recentLogins
        ])->layout('layouts.admin');
    }
}
