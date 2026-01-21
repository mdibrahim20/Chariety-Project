<?php

namespace App\Services;

use App\Models\HeroSlide;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;

class HeroSlideService
{
    // Target dimensions
    const TARGET_WIDTH = 1440;
    const TARGET_HEIGHT = 775;
    const MAX_FILE_SIZE = 500; // KB

    /**
     * Get all hero slides.
     */
    public function getAll()
    {
        return HeroSlide::ordered()->get();
    }

    /**
     * Get active hero slides.
     */
    public function getActive()
    {
        return HeroSlide::active()->ordered()->get();
    }

    /**
     * Create a new hero slide.
     */
    public function create(array $data): HeroSlide
    {
        // Get the next order number
        $maxOrder = HeroSlide::max('order') ?? -1;
        $data['order'] = $maxOrder + 1;

        // Handle image upload
        if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
            $data['image'] = $this->processImage($data['image']);
        }

        return HeroSlide::create($data);
    }

    /**
     * Update a hero slide.
     */
    public function update(HeroSlide $slide, array $data): HeroSlide
    {
        // Handle image upload
        if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
            // Delete old image
            if ($slide->image && Storage::exists($slide->image)) {
                Storage::delete($slide->image);
            }

            $data['image'] = $this->processImage($data['image']);
        } else {
            // Keep existing image
            unset($data['image']);
        }

        $slide->update($data);

        return $slide->fresh();
    }

    /**
     * Delete a hero slide.
     */
    public function delete(HeroSlide $slide): bool
    {
        return $slide->delete();
    }

    /**
     * Reorder slides.
     */
    public function reorder(array $slideIds): void
    {
        foreach ($slideIds as $index => $slideId) {
            HeroSlide::where('id', $slideId)->update(['order' => $index]);
        }
    }

    /**
     * Process and optimize image.
     * - Resize to 1440x775
     * - Convert to WEBP
     * - Compress to under 500KB
     */
    protected function processImage(UploadedFile $file): string
    {
        // Read the image
        $image = Image::read($file->getPathname());

        // Get original dimensions
        $originalWidth = $image->width();
        $originalHeight = $image->height();

        // Calculate aspect ratios
        $targetRatio = self::TARGET_WIDTH / self::TARGET_HEIGHT;
        $originalRatio = $originalWidth / $originalHeight;

        // Resize and crop to fit target dimensions
        if ($originalRatio > $targetRatio) {
            // Image is wider - fit to height and crop width
            $image->scale(height: self::TARGET_HEIGHT);
            $image->crop(self::TARGET_WIDTH, self::TARGET_HEIGHT, position: 'center');
        } else {
            // Image is taller - fit to width and crop height
            $image->scale(width: self::TARGET_WIDTH);
            $image->crop(self::TARGET_WIDTH, self::TARGET_HEIGHT, position: 'center');
        }

        // Generate unique filename
        $filename = 'hero-slides/' . uniqid() . '.webp';

        // Start with quality 90 and reduce if needed
        $quality = 90;
        $encoded = null;

        do {
            $encoded = $image->toWebp($quality);
            $fileSize = strlen($encoded) / 1024; // Size in KB

            if ($fileSize > self::MAX_FILE_SIZE && $quality > 10) {
                $quality -= 10;
            } else {
                break;
            }
        } while ($quality > 10);

        // Store the image
        Storage::put($filename, $encoded);

        return $filename;
    }

    /**
     * Toggle slide status.
     */
    public function toggleStatus(HeroSlide $slide): HeroSlide
    {
        $slide->update(['is_active' => !$slide->is_active]);
        return $slide->fresh();
    }
}
