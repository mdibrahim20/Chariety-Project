<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class VolunteersHeroSection extends Model
{
    protected $fillable = [
        'page_title',
        'breadcrumb_home_label',
        'breadcrumb_current_label',
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

    // Accessor for background image URL
    public function getBackgroundImageUrlAttribute(): ?string
    {
        return $this->background_image ? asset('storage/' . $this->background_image) : null;
    }

    // Auto-delete background image when model is deleted
    protected static function booted()
    {
        static::deleting(function ($section) {
            if ($section->background_image) {
                Storage::delete($section->background_image);
            }
        });
    }

    // Scope for active sections
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
