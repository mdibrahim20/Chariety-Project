<?php

namespace App\Livewire\Admin;

use App\Models\LoginActivity;
use App\Models\User;
use Livewire\Component;

class Dashboard extends Component
{
    public int $totalUsers = 0;
    public int $adminUsers = 0;
    public int $usersWithout2FA = 0;
    public int $failedLogins = 0;
    public $recentLogins = [];
    public $securityAlerts = [];

    public function mount()
    {
        $this->loadStatistics();
        $this->loadRecentLogins();
        $this->loadSecurityAlerts();
    }

    protected function loadStatistics()
    {
        $this->totalUsers = User::count();
        $this->adminUsers = User::where('is_admin', true)->count();
        $this->usersWithout2FA = User::where('is_admin', true)
            ->whereDoesntHave('twoFactorAuth', function ($query) {
                $query->where('enabled', true);
            })
            ->count();
        $this->failedLogins = LoginActivity::where('status', 'failed')
            ->where('created_at', '>=', now()->subDay())
            ->count();
    }

    protected function loadRecentLogins()
    {
        $this->recentLogins = LoginActivity::with('user')
            ->latest()
            ->take(10)
            ->get();
    }

    protected function loadSecurityAlerts()
    {
        $this->securityAlerts = [];

        // Check for users without 2FA
        if ($this->usersWithout2FA > 0) {
            $this->securityAlerts[] = [
                'type' => 'warning',
                'message' => "{$this->usersWithout2FA} admin user(s) don't have 2FA enabled",
                'action' => 'View Users',
                'route' => 'admin.users.index',
            ];
        }

        // Check for recent failed logins
        if ($this->failedLogins > 10) {
            $this->securityAlerts[] = [
                'type' => 'danger',
                'message' => "{$this->failedLogins} failed login attempts in the last 24 hours",
                'action' => 'View Logs',
                'route' => 'admin.settings.security',
            ];
        }

        // Check if current user doesn't have 2FA
        if (!auth()->user()->hasTwoFactorEnabled()) {
            $this->securityAlerts[] = [
                'type' => 'warning',
                'message' => 'Your account is not secured with 2FA',
                'action' => 'Enable 2FA',
                'route' => 'admin.two-factor.setup',
            ];
        }
    }

    public function render()
    {
        return view('livewire.admin.dashboard')->layout('layouts.admin');
    }
}
