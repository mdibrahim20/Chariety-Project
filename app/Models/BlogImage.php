<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class BlogImage extends Model
{
    protected $fillable = [
        'blog_post_id', 'path_large', 'path_medium', 'path_thumb', 'position', 'is_featured',
    ];

    protected $casts = [
        'position' => 'integer',
        'is_featured' => 'boolean',
    ];

    public function blogPost()
    {
        return $this->belongsTo(BlogPost::class);
    }

    public function getLargeUrlAttribute(): ?string
    {
        return $this->path_large ? Storage::url($this->path_large) : null;
    }

    public function getMediumUrlAttribute(): ?string
    {
        return $this->path_medium ? Storage::url($this->path_medium) : null;
    }

    public function getThumbUrlAttribute(): ?string
    {
        return $this->path_thumb ? Storage::url($this->path_thumb) : null;
    }

    protected static function boot()
    {
        parent::boot();
        static::deleting(function ($image) {
            foreach (['path_large', 'path_medium', 'path_thumb'] as $attr) {
                if ($image->{$attr} && Storage::exists($image->{$attr})) {
                    Storage::delete($image->{$attr});
                }
            }
        });
    }
}
