<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TwoFactorAuthentication extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'secret',
        'recovery_codes',
        'enabled',
        'enabled_at',
    ];

    protected $casts = [
        'enabled' => 'boolean',
        'enabled_at' => 'datetime',
    ];

    protected $hidden = [
        'secret',
        'recovery_codes',
    ];

    /**
     * Get the user that owns the two factor authentication.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get recovery codes as array.
     */
    public function getRecoveryCodesArray(): array
    {
        return $this->recovery_codes ? json_decode($this->recovery_codes, true) : [];
    }

    /**
     * Set recovery codes from array.
     */
    public function setRecoveryCodesArray(array $codes): void
    {
        $this->recovery_codes = json_encode($codes);
    }

    /**
     * Use a recovery code.
     */
    public function useRecoveryCode(string $code): bool
    {
        $codes = $this->getRecoveryCodesArray();
        
        if (in_array($code, $codes)) {
            $codes = array_diff($codes, [$code]);
            $this->setRecoveryCodesArray(array_values($codes));
            $this->save();
            
            return true;
        }

        return false;
    }
}
