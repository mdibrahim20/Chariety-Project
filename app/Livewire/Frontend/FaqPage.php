<?php

namespace App\Livewire\Frontend;

use App\Models\FaqHeroSection;
use App\Models\FaqSetting;
use App\Models\FaqCategory;
use App\Models\FaqItem;
use Livewire\Component;

class FaqPage extends Component
{
    public $selectedCategory = 'all';
    public $openAccordion = null;

    public function selectCategory($categorySlug)
    {
        $this->selectedCategory = $categorySlug;
        $this->openAccordion = null; // Reset accordion when changing category
    }

    public function toggleAccordion($itemId)
    {
        $this->openAccordion = $this->openAccordion === $itemId ? null : $itemId;
    }

    public function render()
    {
        $hero = FaqHeroSection::active()->first();
        $settings = FaqSetting::first();
        $categories = FaqCategory::active()->ordered()->with('activeFaqItems')->get();
        
        // Get filtered FAQ items
        $faqItems = collect();
        if ($this->selectedCategory === 'all') {
            // Show all active FAQ items from all categories, ordered
            $faqItems = FaqItem::active()
                ->ordered()
                ->with('category')
                ->get();
        } else {
            // Show FAQ items for the selected category
            $category = $categories->firstWhere('slug', $this->selectedCategory);
            if ($category) {
                $faqItems = $category->activeFaqItems;
            }
        }

        return view('livewire.frontend.faq-page', [
            'hero' => $hero,
            'settings' => $settings,
            'categories' => $categories,
            'faqItems' => $faqItems,
        ])->layout('layouts.guest');
    }
}
