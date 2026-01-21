<?php

namespace App\Models;

use App\Traits\HasRoles;
use App\Traits\HasTwoFactorAuth;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;
    use HasFactory, Notifiable;
    use HasRoles, HasTwoFactorAuth;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
        'two_factor_required',
        'last_login_at',
        'last_login_ip',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean',
            'two_factor_required' => 'boolean',
            'last_login_at' => 'datetime',
        ];
    }

    /**
     * Get the login activities for the user.
     */
    public function loginActivities(): HasMany
    {
        return $this->hasMany(LoginActivity::class);
    }

    /**
     * Record login activity.
     */
    public function recordLogin(string $status, ?string $reason = null): void
    {
        $this->loginActivities()->create([
            'email' => $this->email,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'status' => $status,
            'reason' => $reason,
        ]);

        if ($status === 'success') {
            $this->update([
                'last_login_at' => now(),
                'last_login_ip' => request()->ip(),
            ]);
        }
    }
}
