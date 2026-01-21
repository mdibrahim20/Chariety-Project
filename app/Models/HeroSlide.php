<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class HeroSlide extends Model
{
    protected $fillable = [
        'sub_heading',
        'heading',
        'sub_heading_2',
        'image',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    /**
     * Get the full image URL.
     */
    public function getImageUrlAttribute(): ?string
    {
        if (!$this->image) {
            return null;
        }

        return Storage::url($this->image);
    }

    /**
     * Get the full image path.
     */
    public function getImagePathAttribute(): ?string
    {
        if (!$this->image) {
            return null;
        }

        return Storage::path($this->image);
    }

    /**
     * Scope to get only active slides.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to order by position.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }

    /**
     * Delete the slide and its image.
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($slide) {
            if ($slide->image && Storage::exists($slide->image)) {
                Storage::delete($slide->image);
            }
        });
    }
}
