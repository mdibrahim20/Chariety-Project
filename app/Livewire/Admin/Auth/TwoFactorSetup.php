<?php

namespace App\Livewire\Admin\Auth;

use App\Services\TwoFactorService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class TwoFactorSetup extends Component
{
    public ?string $secret = null;
    public ?string $qrCode = null;
    public array $recoveryCodes = [];
    public string $verificationCode = '';
    public bool $verified = false;
    public bool $showRecoveryCodes = false;

    public function mount(TwoFactorService $twoFactorService)
    {
        $user = Auth::user();

        if ($user->hasTwoFactorEnabled()) {
            return redirect()->route('admin.dashboard');
        }

        $this->secret = $twoFactorService->generateSecretKey();
        $this->qrCode = $twoFactorService->generateQrCode($user, $this->secret);
        $this->recoveryCodes = $twoFactorService->generateRecoveryCodes();
    }

    public function verify(TwoFactorService $twoFactorService)
    {
        $this->validate([
            'verificationCode' => 'required|string|min:6',
        ]);

        if ($twoFactorService->verifyCode($this->secret, $this->verificationCode)) {
            $user = Auth::user();
            $twoFactorService->enableForUser($user, $this->secret, $this->recoveryCodes);

            $this->verified = true;
            $this->showRecoveryCodes = true;

            session()->flash('success', 'Two-factor authentication has been enabled successfully!');
        } else {
            $this->addError('verificationCode', 'The verification code is invalid. Please try again.');
        }
    }

    public function complete()
    {
        if ($this->verified) {
            session(['two_factor_verified' => true]);
            return redirect()->route('admin.dashboard');
        }
    }

    public function render()
    {
        return view('livewire.admin.auth.two-factor-setup')->layout('layouts.admin');
    }
}
