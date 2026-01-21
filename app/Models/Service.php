<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Service extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'short_description',
        'icon',
        'card_image',
        'button_text',
        'button_link',
        'is_active',
        'is_featured',
        'display_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'display_order' => 'integer',
    ];

    // Auto-generate slug from title
    protected static function booted()
    {
        static::creating(function ($service) {
            if (empty($service->slug)) {
                $service->slug = Str::slug($service->title);
            }
        });

        static::deleting(function ($service) {
            if ($service->icon && Storage::exists($service->icon)) {
                Storage::delete($service->icon);
            }
            if ($service->card_image && Storage::exists($service->card_image)) {
                Storage::delete($service->card_image);
            }
        });
    }

    // Accessor for card image URL
    public function getCardImageUrlAttribute(): ?string
    {
        return $this->card_image ? asset('storage/' . $this->card_image) : null;
    }

    // Accessor for icon URL (if it's an uploaded file)
    public function getIconUrlAttribute(): ?string
    {
        if (!$this->icon) return null;
        
        // If icon is a file path (starts with services/)
        if (str_starts_with($this->icon, 'services/')) {
            return asset('storage/' . $this->icon);
        }
        
        // Otherwise, it's an icon class name
        return null;
    }

    // Scope for active services
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Scope for featured services
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    // Scope for ordered display
    public function scopeOrdered($query)
    {
        return $query->orderBy('display_order')->orderBy('id');
    }
}
