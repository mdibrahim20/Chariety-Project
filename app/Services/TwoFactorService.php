<?php

namespace App\Services;

use App\Models\User;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use PragmaRX\Google2FA\Google2FA;

class TwoFactorService
{
    protected Google2FA $google2fa;

    public function __construct()
    {
        $this->google2fa = new Google2FA();
    }

    /**
     * Generate a new secret key.
     */
    public function generateSecretKey(): string
    {
        return $this->google2fa->generateSecretKey();
    }

    /**
     * Generate QR code for 2FA setup.
     */
    public function generateQrCode(User $user, string $secret): string
    {
        $appName = config('app.name', 'Laravel');
        $qrCodeUrl = $this->google2fa->getQRCodeUrl(
            $appName,
            $user->email,
            $secret
        );

        $renderer = new ImageRenderer(
            new RendererStyle(200),
            new SvgImageBackEnd()
        );

        $writer = new Writer($renderer);
        
        return $writer->writeString($qrCodeUrl);
    }

    /**
     * Verify the TOTP code.
     */
    public function verifyCode(string $secret, string $code): bool
    {
        return $this->google2fa->verifyKey($secret, $code, 2); // 2 = window tolerance
    }

    /**
     * Generate recovery codes.
     */
    public function generateRecoveryCodes(int $count = 10): array
    {
        $codes = [];
        for ($i = 0; $i < $count; $i++) {
            $codes[] = strtoupper(substr(bin2hex(random_bytes(5)), 0, 10));
        }
        return $codes;
    }

    /**
     * Enable 2FA for a user.
     */
    public function enableForUser(User $user, string $secret, array $recoveryCodes): void
    {
        $user->enableTwoFactor($secret, $recoveryCodes);
    }

    /**
     * Disable 2FA for a user.
     */
    public function disableForUser(User $user): void
    {
        $user->disableTwoFactor();
    }

    /**
     * Verify recovery code and use it.
     */
    public function verifyRecoveryCode(User $user, string $code): bool
    {
        if (!$user->twoFactorAuth) {
            return false;
        }

        return $user->twoFactorAuth->useRecoveryCode($code);
    }

    /**
     * Regenerate recovery codes for a user.
     */
    public function regenerateRecoveryCodes(User $user): array
    {
        return $user->regenerateRecoveryCodes();
    }
}
