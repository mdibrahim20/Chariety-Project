<?php

namespace App\Services;

use App\Models\NavbarItem;
use Illuminate\Support\Collection;

class NavbarService
{
    /**
     * Get all navbar items as a hierarchical tree.
     */
    public function getTree(): Collection
    {
        return NavbarItem::with('descendants')
            ->rootItems()
            ->get();
    }

    /**
     * Get all navbar items as a flat list with indentation.
     */
    public function getFlatList(): Collection
    {
        $items = NavbarItem::with('parent')->orderBy('order')->get();
        
        return $items->map(function ($item) {
            $prefix = str_repeat('— ', $item->depth);
            return [
                'id' => $item->id,
                'label' => $prefix . $item->label,
                'original_label' => $item->label,
                'value' => $item->id,
            ];
        });
    }

    /**
     * Get navbar items for parent dropdown (excluding item and its descendants).
     */
    public function getParentOptions(?int $excludeId = null): Collection
    {
        $items = NavbarItem::with('parent')->orderBy('order')->get();
        
        if ($excludeId) {
            $excludeItem = $items->firstWhere('id', $excludeId);
            $excludeIds = $this->getDescendantIds($excludeItem);
            $excludeIds[] = $excludeId;
            
            $items = $items->reject(fn($item) => in_array($item->id, $excludeIds));
        }
        
        return $items->map(function ($item) {
            $prefix = str_repeat('— ', $item->depth);
            return [
                'id' => $item->id,
                'label' => $prefix . $item->label,
            ];
        })->prepend(['id' => null, 'label' => 'None (Root Level)']);
    }

    /**
     * Get all descendant IDs of an item.
     */
    protected function getDescendantIds(?NavbarItem $item): array
    {
        if (!$item) {
            return [];
        }

        $ids = [];
        
        foreach ($item->children as $child) {
            $ids[] = $child->id;
            $ids = array_merge($ids, $this->getDescendantIds($child));
        }
        
        return $ids;
    }

    /**
     * Create a new navbar item.
     */
    public function create(array $data): NavbarItem
    {
        // Get the next order number
        $query = NavbarItem::query();
        
        if (isset($data['parent_id'])) {
            $query->where('parent_id', $data['parent_id']);
        } else {
            $query->whereNull('parent_id');
        }
        
        $maxOrder = $query->max('order') ?? -1;
        $data['order'] = $maxOrder + 1;
        
        return NavbarItem::create($data);
    }

    /**
     * Update a navbar item.
     */
    public function update(NavbarItem $item, array $data): NavbarItem
    {
        // If parent changed, update order
        if (isset($data['parent_id']) && $data['parent_id'] != $item->parent_id) {
            $query = NavbarItem::query();
            
            if ($data['parent_id']) {
                $query->where('parent_id', $data['parent_id']);
            } else {
                $query->whereNull('parent_id');
            }
            
            $maxOrder = $query->max('order') ?? -1;
            $data['order'] = $maxOrder + 1;
        }
        
        $item->update($data);
        
        return $item->fresh();
    }

    /**
     * Delete a navbar item.
     */
    public function delete(NavbarItem $item): bool
    {
        return $item->delete();
    }

    /**
     * Reorder items.
     */
    public function reorder(array $items): void
    {
        foreach ($items as $index => $itemId) {
            NavbarItem::where('id', $itemId)->update(['order' => $index]);
        }
    }

    /**
     * Get active navbar items for frontend display.
     */
    public function getActiveMenu(): Collection
    {
        return NavbarItem::with('children')
            ->active()
            ->rootItems()
            ->get();
    }
}
