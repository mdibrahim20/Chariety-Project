<?php

namespace App\Livewire\Admin\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Component;

class Login extends Component
{
    public string $email = '';
    public string $password = '';
    public bool $remember = false;

    protected $rules = [
        'email' => 'required|email',
        'password' => 'required|min:6',
    ];

    public function login()
    {
        $this->validate();

        $key = 'admin-login:' . request()->ip();

        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            
            $this->addError('email', "Too many login attempts. Please try again in {$seconds} seconds.");
            return;
        }

        $credentials = [
            'email' => $this->email,
            'password' => $this->password,
        ];

        $user = User::where('email', $this->email)->first();

        if (!$user || !$user->isAdmin()) {
            RateLimiter::hit($key, 60);
            
            // Log failed attempt
            if ($user) {
                $user->recordLogin('failed', 'Not an admin user');
            }

            $this->addError('email', 'These credentials do not match our records or you do not have admin access.');
            return;
        }

        if (Auth::attempt($credentials, $this->remember)) {
            RateLimiter::clear($key);
            
            request()->session()->regenerate();

            $user = Auth::user();

            // Check if 2FA is enabled
            if ($user->hasTwoFactorEnabled()) {
                Auth::logout();
                session(['2fa_user_id' => $user->id]);
                $user->recordLogin('two_factor_required');
                
                return redirect()->route('admin.two-factor.verify');
            }

            $user->recordLogin('success');

            return redirect()->intended(route('admin.dashboard'));
        }

        RateLimiter::hit($key, 60);
        
        if ($user) {
            $user->recordLogin('failed', 'Invalid password');
        }

        $this->addError('email', 'These credentials do not match our records.');
    }

    public function render()
    {
        return view('livewire.admin.auth.login')->layout('layouts.admin-guest');
    }
}
