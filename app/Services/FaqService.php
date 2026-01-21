<?php

namespace App\Services;

use App\Models\FaqSetting;
use App\Models\FaqCategory;
use App\Models\FaqItem;

class FaqService
{
    public function getSettings(): FaqSetting
    {
        return FaqSetting::firstOrCreate(
            [],
            ['section_heading' => 'Frequently Asked Questions']
        );
    }

    public function updateSettings(array $data): FaqSetting
    {
        $settings = $this->getSettings();
        $settings->update($data);
        return $settings->fresh();
    }

    public function upsertCategory(array $data, ?FaqCategory $category = null): FaqCategory
    {
        if ($category) {
            $category->update($data);
            return $category;
        }
        
        return FaqCategory::create($data);
    }

    public function deleteCategory(FaqCategory $category): void
    {
        // This will cascade delete all FAQ items in this category
        $category->delete();
    }

    public function upsertFaqItem(array $data, ?FaqItem $item = null): FaqItem
    {
        // Sanitize answer (basic HTML cleaning)
        if (isset($data['answer'])) {
            $data['answer'] = $this->sanitizeHtml($data['answer']);
        }

        if ($item) {
            $item->update($data);
            return $item;
        }
        
        return FaqItem::create($data);
    }

    public function deleteFaqItem(FaqItem $item): void
    {
        $item->delete();
    }

    private function sanitizeHtml(string $html): string
    {
        // Remove script and style tags
        $html = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', '', $html);
        $html = preg_replace('/<style\b[^>]*>(.*?)<\/style>/is', '', $html);
        
        // Remove event handlers
        $html = preg_replace('/\s*on\w+\s*=\s*["\'].*?["\']/i', '', $html);
        
        // Remove javascript: from href and src
        $html = preg_replace('/href\s*=\s*["\']javascript:.*?["\']/i', '', $html);
        $html = preg_replace('/src\s*=\s*["\']javascript:.*?["\']/i', '', $html);
        
        return trim($html);
    }
}
