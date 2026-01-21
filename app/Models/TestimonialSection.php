<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestimonialSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'badge_text',
        'main_heading',
        'sub_heading',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Scope for active section
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
