<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Volunteer extends Model
{
    protected $fillable = [
        'name',
        'designation',
        'profile_photo',
        'facebook_url',
        'instagram_url',
        'twitter_url',
        'linkedin_url',
        'is_active',
        'display_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'display_order' => 'integer',
    ];

    // Auto-delete profile photo when model is deleted
    protected static function booted()
    {
        static::deleting(function ($volunteer) {
            if ($volunteer->profile_photo && Storage::exists($volunteer->profile_photo)) {
                Storage::delete($volunteer->profile_photo);
            }
        });
    }

    // Accessor for profile photo URL
    public function getProfilePhotoUrlAttribute(): ?string
    {
        return $this->profile_photo ? asset('storage/' . $this->profile_photo) : null;
    }

    // Check if volunteer has any social media links
    public function getHasSocialLinksAttribute(): bool
    {
        return !empty($this->facebook_url) 
            || !empty($this->instagram_url) 
            || !empty($this->twitter_url) 
            || !empty($this->linkedin_url);
    }

    // Get sanitized social media URLs
    public function getSanitizedFacebookUrlAttribute(): ?string
    {
        return $this->sanitizeUrl($this->facebook_url);
    }

    public function getSanitizedInstagramUrlAttribute(): ?string
    {
        return $this->sanitizeUrl($this->instagram_url);
    }

    public function getSanitizedTwitterUrlAttribute(): ?string
    {
        return $this->sanitizeUrl($this->twitter_url);
    }

    public function getSanitizedLinkedinUrlAttribute(): ?string
    {
        return $this->sanitizeUrl($this->linkedin_url);
    }

    // Sanitize URL helper
    private function sanitizeUrl(?string $url): ?string
    {
        if (empty($url)) return null;
        
        $url = trim($url);
        
        // Basic URL validation
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            return null;
        }
        
        // Only allow http and https protocols
        $parsed = parse_url($url);
        if (!isset($parsed['scheme']) || !in_array($parsed['scheme'], ['http', 'https'])) {
            return null;
        }
        
        return $url;
    }

    // Scope for active volunteers
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Scope for ordered display
    public function scopeOrdered($query)
    {
        return $query->orderBy('display_order')->orderBy('id');
    }
}
