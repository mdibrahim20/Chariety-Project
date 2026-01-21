<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class AboutUsSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'badge_text',
        'main_heading',
        'description',
        'feature1_icon',
        'feature1_title',
        'feature1_description',
        'feature2_icon',
        'feature2_title',
        'feature2_description',
        'right_paragraph',
        'cta_button_text',
        'cta_button_link',
        'cta_button_target',
        'image1',
        'image2',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the URL for image1
     */
    public function getImage1UrlAttribute(): ?string
    {
        return $this->image1 ? Storage::url($this->image1) : null;
    }

    /**
     * Get the file path for image1
     */
    public function getImage1PathAttribute(): ?string
    {
        return $this->image1 ? Storage::path($this->image1) : null;
    }

    /**
     * Get the URL for image2
     */
    public function getImage2UrlAttribute(): ?string
    {
        return $this->image2 ? Storage::url($this->image2) : null;
    }

    /**
     * Get the file path for image2
     */
    public function getImage2PathAttribute(): ?string
    {
        return $this->image2 ? Storage::path($this->image2) : null;
    }

    /**
     * Get the URL for feature1 icon
     */
    public function getFeature1IconUrlAttribute(): ?string
    {
        return $this->feature1_icon ? Storage::url($this->feature1_icon) : null;
    }

    /**
     * Get the URL for feature2 icon
     */
    public function getFeature2IconUrlAttribute(): ?string
    {
        return $this->feature2_icon ? Storage::url($this->feature2_icon) : null;
    }

    /**
     * Boot the model
     */
    protected static function boot(): void
    {
        parent::boot();

        static::deleting(function ($section) {
            // Delete image files when section is deleted
            if ($section->image1 && Storage::exists($section->image1)) {
                Storage::delete($section->image1);
            }
            if ($section->image2 && Storage::exists($section->image2)) {
                Storage::delete($section->image2);
            }
            if ($section->feature1_icon && Storage::exists($section->feature1_icon)) {
                Storage::delete($section->feature1_icon);
            }
            if ($section->feature2_icon && Storage::exists($section->feature2_icon)) {
                Storage::delete($section->feature2_icon);
            }
        });
    }

    /**
     * Scope for active sections
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
