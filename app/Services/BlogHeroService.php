<?php

namespace App\Services;

use App\Models\BlogHeroSection;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;

class BlogHeroService
{
    const TARGET_WIDTH = 1920;
    const TARGET_HEIGHT = 600;
    const MAX_FILE_SIZE = 500 * 1024;

    public function getSection(): BlogHeroSection
    {
        return BlogHeroSection::firstOrCreate(
            ['id' => 1],
            [
                'page_title' => 'Our Blog Details',
                'breadcrumb_home_label' => 'Home',
                'breadcrumb_current_label' => 'Our Blog Details',
                'is_active' => true,
                'overlay_enabled' => true,
                'overlay_opacity' => 50,
            ]
        );
    }

    public function updateSection(array $data): BlogHeroSection
    {
        $section = $this->getSection();

        if (isset($data['background_image']) && $data['background_image'] instanceof UploadedFile) {
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

    private function processBackgroundImage(UploadedFile $file): string
    {
        $image = Image::read($file->getRealPath());
        $targetRatio = self::TARGET_WIDTH / self::TARGET_HEIGHT;
        $currentRatio = $image->width() / $image->height();

        if ($currentRatio > $targetRatio) {
            $image->scale(height: self::TARGET_HEIGHT);
        } else {
            $image->scale(width: self::TARGET_WIDTH);
        }

        $image->crop(self::TARGET_WIDTH, self::TARGET_HEIGHT, position: 'center');

        $quality = 90;
        $tempPath = storage_path('app/temp_blog_hero_bg.webp');
        do {
            $image->toWebp($quality)->save($tempPath);
            $size = filesize($tempPath);
            if ($size <= self::MAX_FILE_SIZE || $quality <= 10) break;
            $quality -= 10;
        } while (true);

        $filename = 'blog-hero/background-' . uniqid() . '.webp';
        Storage::put($filename, file_get_contents($tempPath));
        @unlink($tempPath);
        return $filename;
    }

    public function deleteBackgroundImage(): void
    {
        $section = $this->getSection();
        if ($section->background_image && Storage::exists($section->background_image)) {
            Storage::delete($section->background_image);
            $section->update(['background_image' => null]);
        }
    }
}
