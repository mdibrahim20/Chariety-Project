<?php

namespace App\Livewire\Admin\Auth;

use App\Services\TwoFactorService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class TwoFactorVerify extends Component
{
    public string $code = '';
    public bool $useRecoveryCode = false;

    protected $rules = [
        'code' => 'required|string',
    ];

    public function verify(TwoFactorService $twoFactorService)
    {
        $this->validate();

        $userId = session('2fa_user_id');
        
        if (!$userId) {
            return redirect()->route('admin.login');
        }

        $user = \App\Models\User::find($userId);

        if (!$user) {
            return redirect()->route('admin.login');
        }

        $verified = false;

        if ($this->useRecoveryCode) {
            // Verify using recovery code
            $verified = $twoFactorService->verifyRecoveryCode($user, $this->code);
        } else {
            // Verify using TOTP code
            $secret = $user->getTwoFactorSecret();
            if ($secret) {
                $verified = $twoFactorService->verifyCode($secret, $this->code);
            }
        }

        if ($verified) {
            session()->forget('2fa_user_id');
            session(['two_factor_verified' => true]);
            
            Auth::login($user);
            request()->session()->regenerate();

            $user->recordLogin('success');

            return redirect()->route('admin.dashboard');
        }

        $this->addError('code', 'The code you entered is invalid.');
    }

    public function toggleRecoveryCode()
    {
        $this->useRecoveryCode = !$this->useRecoveryCode;
        $this->code = '';
        $this->resetErrorBag();
    }

    public function render()
    {
        return view('livewire.admin.auth.two-factor-verify')->layout('layouts.admin-guest');
    }
}
