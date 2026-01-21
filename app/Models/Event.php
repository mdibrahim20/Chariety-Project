<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Event extends Model
{
    protected $fillable = [
        'title', 'slug', 'summary', 'content_html', 'is_active', 'ordering',
        'featured_image_id', 'meta_title', 'meta_description', 'meta_image',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'ordering' => 'integer',
        'featured_image_id' => 'integer',
    ];

    // Relationships
    public function images()
    {
        return $this->hasMany(EventImage::class)->orderBy('position');
    }

    public function featuredImage()
    {
        return $this->belongsTo(EventImage::class, 'featured_image_id');
    }

    public function donations()
    {
        return $this->hasMany(Donation::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($event) {
            if (empty($event->slug)) {
                $event->slug = Str::slug($event->title);
            }
        });
    }
}
