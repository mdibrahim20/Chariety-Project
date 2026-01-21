<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Testimonial extends Model
{
    use HasFactory;

    protected $fillable = [
        'rating',
        'review_text',
        'reviewer_name',
        'reviewer_role',
        'avatar',
        'status',
        'display_order',
    ];

    protected $casts = [
        'rating' => 'integer',
        'display_order' => 'integer',
    ];

    /**
     * Get the avatar URL
     */
    public function getAvatarUrlAttribute(): ?string
    {
        return $this->avatar ? Storage::url($this->avatar) : null;
    }

    /**
     * Get the avatar file path
     */
    public function getAvatarPathAttribute(): ?string
    {
        return $this->avatar ? Storage::path($this->avatar) : null;
    }

    /**
     * Get star rating as an array for display
     */
    public function getStarsAttribute(): array
    {
        $stars = [];
        for ($i = 1; $i <= 5; $i++) {
            $stars[] = $i <= $this->rating;
        }
        return $stars;
    }

    /**
     * Boot the model
     */
    protected static function boot(): void
    {
        parent::boot();

        static::deleting(function ($testimonial) {
            // Delete avatar when testimonial is deleted
            if ($testimonial->avatar && Storage::exists($testimonial->avatar)) {
                Storage::delete($testimonial->avatar);
            }
        });

        static::creating(function ($testimonial) {
            // Auto-assign display order if not set
            if (!$testimonial->display_order) {
                $testimonial->display_order = static::max('display_order') + 1;
            }
        });
    }

    /**
     * Scope for active testimonials
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope for pending testimonials
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope for disabled testimonials
     */
    public function scopeDisabled($query)
    {
        return $query->where('status', 'disabled');
    }

    /**
     * Scope for ordered testimonials
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('display_order', 'asc');
    }
}
