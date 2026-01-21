<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class EventsHeroSection extends Model
{
    protected $fillable = [
        'page_title',
        'breadcrumb_home_label',
        'breadcrumb_current_page_label',
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
     * Get the full URL for the background image
     */
    public function getBackgroundImageUrlAttribute(): ?string
    {
        return $this->background_image 
            ? Storage::url($this->background_image) 
            : null;
    }

    /**
     * Get the background image path
     */
    public function getBackgroundImagePathAttribute(): ?string
    {
        return $this->background_image;
    }

    /**
     * Boot method to handle model events
     */
    protected static function boot()
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
     * Scope to get only active sections
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
