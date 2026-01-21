<?php

namespace App\Livewire\Admin\Settings;

use App\Services\MailConfigService;
use Livewire\Component;

class Email extends Component
{
    public string $mail_host = '';
    public string $mail_port = '587';
    public string $mail_username = '';
    public string $mail_password = '';
    public string $mail_encryption = 'tls';
    public string $mail_from_address = '';
    public string $mail_from_name = '';
    public string $test_email = '';
    public bool $showPassword = false;

    protected $rules = [
        'mail_host' => 'required|string',
        'mail_port' => 'required|integer',
        'mail_username' => 'required|string',
        'mail_password' => 'required|string',
        'mail_encryption' => 'required|in:tls,ssl',
        'mail_from_address' => 'required|email',
        'mail_from_name' => 'required|string',
    ];

    public function mount(MailConfigService $mailConfig)
    {
        $settings = $mailConfig->getSettings();
        
        $this->mail_host = $settings['mail_host'] ?? '';
        $this->mail_port = $settings['mail_port'] ?? '587';
        $this->mail_username = $settings['mail_username'] ?? '';
        $this->mail_password = $settings['mail_password'] ?? '';
        $this->mail_encryption = $settings['mail_encryption'] ?? 'tls';
        $this->mail_from_address = $settings['mail_from_address'] ?? '';
        $this->mail_from_name = $settings['mail_from_name'] ?? config('app.name');
    }

    public function save(MailConfigService $mailConfig)
    {
        $this->validate();

        $mailConfig->save([
            'mail_host' => $this->mail_host,
            'mail_port' => $this->mail_port,
            'mail_username' => $this->mail_username,
            'mail_password' => $this->mail_password,
            'mail_encryption' => $this->mail_encryption,
            'mail_from_address' => $this->mail_from_address,
            'mail_from_name' => $this->mail_from_name,
        ]);

        session()->flash('success', 'Email settings saved successfully.');
    }

    public function testEmail(MailConfigService $mailConfig)
    {
        $this->validate(['test_email' => 'required|email']);

        if ($mailConfig->testConfiguration($this->test_email)) {
            session()->flash('success', 'Test email sent successfully!');
        } else {
            session()->flash('error', 'Failed to send test email. Please check your settings.');
        }

        $this->test_email = '';
    }

    public function render()
    {
        return view('livewire.admin.settings.email')->layout('layouts.admin');
    }
}
