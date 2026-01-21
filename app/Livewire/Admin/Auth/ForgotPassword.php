<?php

namespace App\Livewire\Admin\Auth;

use Illuminate\Support\Facades\Password;
use Livewire\Component;

class ForgotPassword extends Component
{
    public string $email = '';
    public string $message = '';
    public string $messageType = '';

    protected $rules = [
        'email' => 'required|email|exists:users,email',
    ];

    protected $messages = [
        'email.exists' => 'We could not find a user with that email address.',
    ];

    public function sendResetLink()
    {
        $this->validate();

        $status = Password::sendResetLink(['email' => $this->email]);

        if ($status === Password::RESET_LINK_SENT) {
            $this->messageType = 'success';
            $this->message = 'We have emailed your password reset link!';
            $this->email = '';
        } else {
            $this->messageType = 'error';
            $this->message = 'Unable to send reset link. Please try again.';
        }
    }

    public function render()
    {
        return view('livewire.admin.auth.forgot-password')->layout('layouts.admin-guest');
    }
}
