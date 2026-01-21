<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class NewsletterSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'heading_text',
        'description_text',
        'email_placeholder',
        'button_text',
        'success_message',
        'error_message',
        'background_image',
        'is_active',
        'overlay_enabled',
        'overlay_opacity',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'overlay_enabled' => 'boolean',
        'overlay_opacity' => 'integer',
    ];

    /**
     * Get the background image URL
     */
    public function getBackgroundImageUrlAttribute(): ?string
    {
        return $this->background_image ? Storage::url($this->background_image) : null;
    }

    /**
     * Get the background image file path
     */
    public function getBackgroundImagePathAttribute(): ?string
    {
        return $this->background_image ? Storage::path($this->background_image) : null;
    }

    /**
     * Boot the model
     */
    protected static function boot(): void
    {
        parent::boot();

        static::deleting(function ($section) {
            // Delete background image when section is deleted
            if ($section->background_image && Storage::exists($section->background_image)) {
                Storage::delete($section->background_image);
            }
        });
    }

    /**
     * Scope for active section
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
