<?php

namespace App\Services;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;

class MailConfigService
{
    protected SettingsService $settings;

    public function __construct(SettingsService $settings)
    {
        $this->settings = $settings;
    }

    /**
     * Load mail settings from database and apply to config.
     */
    public function loadFromDatabase(): void
    {
        $mailSettings = $this->settings->getByGroup('email');

        if (empty($mailSettings)) {
            return;
        }

        $config = [
            'mail.mailers.smtp.host' => $mailSettings['mail_host'] ?? null,
            'mail.mailers.smtp.port' => $mailSettings['mail_port'] ?? 587,
            'mail.mailers.smtp.encryption' => $mailSettings['mail_encryption'] ?? 'tls',
            'mail.mailers.smtp.username' => $mailSettings['mail_username'] ?? null,
            'mail.mailers.smtp.password' => $mailSettings['mail_password'] ?? null,
            'mail.from.address' => $mailSettings['mail_from_address'] ?? null,
            'mail.from.name' => $mailSettings['mail_from_name'] ?? config('app.name'),
        ];

        foreach ($config as $key => $value) {
            if ($value !== null) {
                Config::set($key, $value);
            }
        }

        // Purge the mailer to apply new settings
        Mail::purge('smtp');
    }

    /**
     * Save mail settings to database.
     */
    public function save(array $settings): void
    {
        $this->settings->setMultiple($settings, 'email');
        $this->loadFromDatabase();
    }

    /**
     * Test mail configuration by sending a test email.
     */
    public function testConfiguration(string $toEmail): bool
    {
        try {
            $this->loadFromDatabase();

            Mail::raw('This is a test email from ' . config('app.name'), function ($message) use ($toEmail) {
                $message->to($toEmail)
                    ->subject('Test Email - ' . config('app.name'));
            });

            return true;
        } catch (\Exception $e) {
            \Log::error('Mail test failed: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Get current mail settings.
     */
    public function getSettings(): array
    {
        return $this->settings->getByGroup('email');
    }
}
