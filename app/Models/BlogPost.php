<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class BlogPost extends Model
{
    protected $fillable = [
        'title', 'slug', 'featured_image_id', 'content_html', 'author',
        'publish_date', 'category', 'is_active', 'is_featured',
        'meta_title', 'meta_description', 'meta_image',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'publish_date' => 'datetime',
    ];

    public function images()
    {
        return $this->hasMany(BlogImage::class)->orderBy('position');
    }

    public function featuredImage()
    {
        return $this->belongsTo(BlogImage::class, 'featured_image_id');
    }

    public function tags()
    {
        return $this->belongsToMany(BlogTag::class, 'blog_post_tag');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($post) {
            if (empty($post->slug)) {
                $post->slug = Str::slug($post->title);
            }
            if (empty($post->publish_date)) {
                $post->publish_date = now();
            }
        });
    }
}
