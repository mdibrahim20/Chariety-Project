<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class NavbarItem extends Model
{
    protected $fillable = [
        'parent_id',
        'label',
        'route',
        'order',
        'is_active',
        'opens_in_new_tab',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'opens_in_new_tab' => 'boolean',
        'order' => 'integer',
    ];

    /**
     * Get the parent menu item.
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(NavbarItem::class, 'parent_id');
    }

    /**
     * Get the child menu items.
     */
    public function children(): HasMany
    {
        return $this->hasMany(NavbarItem::class, 'parent_id')->orderBy('order');
    }

    /**
     * Get all descendants recursively.
     */
    public function descendants(): HasMany
    {
        return $this->children()->with('descendants');
    }

    /**
     * Check if this item has children.
     */
    public function hasChildren(): bool
    {
        return $this->children()->exists();
    }

    /**
     * Get the depth level of this item (0 for root items).
     */
    public function getDepthAttribute(): int
    {
        $depth = 0;
        $parent = $this->parent;
        
        while ($parent) {
            $depth++;
            $parent = $parent->parent;
        }
        
        return $depth;
    }

    /**
     * Scope to get only root items (no parent).
     */
    public function scopeRootItems($query)
    {
        return $query->whereNull('parent_id')->orderBy('order');
    }

    /**
     * Scope to get only active items.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get the full breadcrumb path.
     */
    public function getBreadcrumbAttribute(): string
    {
        $labels = [];
        $item = $this;
        
        while ($item) {
            array_unshift($labels, $item->label);
            $item = $item->parent;
        }
        
        return implode(' > ', $labels);
    }
}
