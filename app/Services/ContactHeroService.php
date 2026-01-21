<?php

namespace App\Services;

use App\Models\ContactHeroSection;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class ContactHeroService
{
    const HERO_WIDTH = 1920;
    const HERO_HEIGHT = 600;
    const MAX_FILE_SIZE = 500 * 1024;

    public function getSection(): ContactHeroSection
    {
        return ContactHeroSection::firstOrCreate(
            [],
            [
                'page_title' => 'Contact Us',
                'breadcrumb_home_label' => 'Home',
                'breadcrumb_current_label' => 'Contact Us',
                'is_active' => true,
                'overlay_enabled' => true,
                'overlay_opacity' => 50,
            ]
        );
    }

    public function updateSection(array $data): ContactHeroSection
    {
        $section = $this->getSection();

        if (isset($data['background_image']) && $data['background_image'] instanceof UploadedFile) {
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

    private function processBackgroundImage(UploadedFile $file): string
    {
        $manager = new ImageManager(new Driver());
        $image = $manager->read($file->getRealPath());
        $image->cover(self::HERO_WIDTH, self::HERO_HEIGHT);

        $quality = 90;
        $tempPath = tempnam(sys_get_temp_dir(), 'hero_') . '.webp';
        
        do {
            $image->toWebp($quality)->save($tempPath);
            $fileSize = filesize($tempPath);
            $quality -= 10;
        } while ($fileSize > self::MAX_FILE_SIZE && $quality >= 10);

        $filename = 'contact/hero/' . uniqid() . '.webp';
        Storage::put($filename, file_get_contents($tempPath));
        unlink($tempPath);
        
        return $filename;
    }

    public function deleteBackgroundImage(): void
    {
        $section = $this->getSection();
        if ($section->background_image) {
            Storage::delete($section->background_image);
            $section->update(['background_image' => null]);
        }
    }
}
