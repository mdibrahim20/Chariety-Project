<?php

namespace App\Traits;

use App\Models\TwoFactorAuthentication;
use Illuminate\Database\Eloquent\Relations\HasOne;

trait HasTwoFactorAuth
{
    /**
     * Get the two factor authentication record.
     */
    public function twoFactorAuth(): HasOne
    {
        return $this->hasOne(TwoFactorAuthentication::class);
    }

    /**
     * Check if two factor authentication is enabled.
     */
    public function hasTwoFactorEnabled(): bool
    {
        return $this->twoFactorAuth && $this->twoFactorAuth->enabled;
    }

    /**
     * Enable two factor authentication.
     */
    public function enableTwoFactor(string $secret, array $recoveryCodes): void
    {
        $this->twoFactorAuth()->updateOrCreate(
            ['user_id' => $this->id],
            [
                'secret' => $secret,
                'recovery_codes' => json_encode($recoveryCodes),
                'enabled' => true,
                'enabled_at' => now(),
            ]
        );
    }

    /**
     * Disable two factor authentication.
     */
    public function disableTwoFactor(): void
    {
        $this->twoFactorAuth()->delete();
    }

    /**
     * Get two factor secret.
     */
    public function getTwoFactorSecret(): ?string
    {
        return $this->twoFactorAuth?->secret;
    }

    /**
     * Get recovery codes.
     */
    public function getRecoveryCodes(): array
    {
        return $this->twoFactorAuth?->getRecoveryCodesArray() ?? [];
    }

    /**
     * Regenerate recovery codes.
     */
    public function regenerateRecoveryCodes(): array
    {
        $codes = [];
        for ($i = 0; $i < 10; $i++) {
            $codes[] = strtoupper(substr(bin2hex(random_bytes(5)), 0, 10));
        }

        if ($this->twoFactorAuth) {
            $this->twoFactorAuth->setRecoveryCodesArray($codes);
            $this->twoFactorAuth->save();
        }

        return $codes;
    }
}
