<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class EventImage extends Model
{
    protected $fillable = [
        'event_id', 'path_featured', 'path_thumb', 'position', 'is_featured',
    ];

    protected $casts = [
        'position' => 'integer',
        'is_featured' => 'boolean',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function getFeaturedUrlAttribute(): ?string
    {
        return $this->path_featured ? Storage::url($this->path_featured) : null;
    }

    public function getThumbUrlAttribute(): ?string
    {
        return $this->path_thumb ? Storage::url($this->path_thumb) : null;
    }

    public static function boot()
    {
        parent::boot();

        static::deleting(function ($image) {
            foreach (['path_featured','path_thumb'] as $attr) {
                $path = $image->{$attr};
                if ($path && Storage::exists($path)) {
                    Storage::delete($path);
                }
            }
        });
    }
}
