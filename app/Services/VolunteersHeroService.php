<?php

namespace App\Services;

use App\Models\VolunteersHeroSection;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class VolunteersHeroService
{
    // Hero banner dimensions
    const HERO_WIDTH = 1920;
    const HERO_HEIGHT = 600;
    const MAX_FILE_SIZE = 500 * 1024; // 500 KB

    /**
     * Get the singleton hero section (create if doesn't exist)
     */
    public function getSection(): VolunteersHeroSection
    {
        return VolunteersHeroSection::firstOrCreate(
            [],
            [
                'page_title' => 'Meet our Volunteer',
                'breadcrumb_home_label' => 'Home',
                'breadcrumb_current_label' => 'Our Volunteers',
                'is_active' => true,
                'overlay_enabled' => true,
                'overlay_opacity' => 50,
            ]
        );
    }

    /**
     * Update hero section
     */
    public function updateSection(array $data): VolunteersHeroSection
    {
        $section = $this->getSection();

        // Process background image if uploaded
        if (isset($data['background_image']) && $data['background_image'] instanceof UploadedFile) {
            // Delete old image
            if ($section->background_image) {
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
     */
    private function processBackgroundImage(UploadedFile $file): string
    {
        $manager = new ImageManager(new Driver());
        $image = $manager->read($file->getRealPath());

        // Resize to hero dimensions (center crop)
        $image->cover(self::HERO_WIDTH, self::HERO_HEIGHT);

        // Quality optimization loop
        $quality = 90;
        $tempPath = tempnam(sys_get_temp_dir(), 'hero_') . '.webp';
        
        do {
            $image->toWebp($quality)->save($tempPath);
            $fileSize = filesize($tempPath);
            $quality -= 10;
        } while ($fileSize > self::MAX_FILE_SIZE && $quality >= 10);

        // Store in storage/app/public/volunteers/hero/
        $filename = 'volunteers/hero/' . uniqid() . '.webp';
        Storage::put($filename, file_get_contents($tempPath));
        
        unlink($tempPath);
        return $filename;
    }

    /**
     * Delete background image
     */
    public function deleteBackgroundImage(): void
    {
        $section = $this->getSection();
        if ($section->background_image) {
            Storage::delete($section->background_image);
            $section->update(['background_image' => null]);
        }
    }
}
