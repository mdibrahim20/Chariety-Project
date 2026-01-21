<?php

namespace App\Services;

use App\Models\EventsHeroSection;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;

class EventsHeroService
{
    // Hero banner can be any size, we'll optimize it
    // Common hero dimensions: 1920×600, 1920×800, etc.
    const TARGET_WIDTH = 1920;
    const TARGET_HEIGHT = 600;
    const TARGET_SIZE = 200 * 1024; // ~200 KB target
    const MAX_FILE_SIZE = 500 * 1024; // 500 KB hard limit

    /**
     * Get or create the events hero section (singleton)
     */
    public function getSection(): EventsHeroSection
    {
        return EventsHeroSection::firstOrCreate(
            ['id' => 1],
            [
                'page_title' => 'Events Details',
                'breadcrumb_home_label' => 'Home',
                'breadcrumb_current_page_label' => 'Events',
                'is_active' => true,
                'overlay_enabled' => true,
                'overlay_opacity' => 50,
            ]
        );
    }

    /**
     * Update the events hero section
     */
    public function updateSection(array $data): EventsHeroSection
    {
        $section = $this->getSection();

        // Process background image if uploaded
        if (isset($data['background_image']) && $data['background_image'] instanceof UploadedFile) {
            // Delete old background image
            if ($section->background_image && Storage::exists($section->background_image)) {
                Storage::delete($section->background_image);
            }

            $data['background_image'] = $this->processBackgroundImage($data['background_image']);
        } else {
            unset($data['background_image']);
        }

        $section->update($data);

        return $section->fresh();
    }

    /**
     * Process and optimize background image
     * Accepts any size, converts to WEBP, compresses to <500KB
     */
    private function processBackgroundImage(UploadedFile $file): string
    {
        $image = Image::read($file->getRealPath());

        // Calculate aspect ratios (16:5 for hero banner)
        $targetRatio = self::TARGET_WIDTH / self::TARGET_HEIGHT;
        $currentRatio = $image->width() / $image->height();

        // Resize to fit while maintaining aspect ratio, then crop
        if ($currentRatio > $targetRatio) {
            // Image is wider - fit to height
            $image->scale(height: self::TARGET_HEIGHT);
        } else {
            // Image is taller - fit to width
            $image->scale(width: self::TARGET_WIDTH);
        }

        // Center crop to exact dimensions
        $image->crop(self::TARGET_WIDTH, self::TARGET_HEIGHT, position: 'center');

        // Convert to WEBP with quality optimization
        $quality = 90;
        $tempPath = storage_path('app/temp_events_hero_bg.webp');

        do {
            $image->toWebp($quality)->save($tempPath);
            $fileSize = filesize($tempPath);

            if ($fileSize <= self::MAX_FILE_SIZE || $quality <= 10) {
                break;
            }

            $quality -= 10;
        } while (true);

        // Store the final image
        $filename = 'events-hero/background-' . uniqid() . '.webp';
        Storage::put($filename, file_get_contents($tempPath));

        // Clean up temp file
        @unlink($tempPath);

        return $filename;
    }

    /**
     * Delete background image
     */
    public function deleteBackgroundImage(): void
    {
        $section = $this->getSection();
        
        if ($section->background_image && Storage::exists($section->background_image)) {
            Storage::delete($section->background_image);
            $section->update(['background_image' => null]);
        }
    }
}
