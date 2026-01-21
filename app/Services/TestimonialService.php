<?php

namespace App\Services;

use App\Models\Testimonial;
use App\Models\TestimonialSection;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;

class TestimonialService
{
    // Avatar dimensions (square for consistent display)
    const AVATAR_SIZE = 100; // 100x100px
    const MAX_AVATAR_SIZE = 200 * 1024; // 200 KB

    /**
     * Get or create the testimonial section (singleton)
     */
    public function getSection(): TestimonialSection
    {
        return TestimonialSection::firstOrCreate(
            ['id' => 1],
            [
                'main_heading' => 'Stories from the Heart',
                'badge_text' => 'Testimonial',
                'is_active' => true,
            ]
        );
    }

    /**
     * Update the section header
     */
    public function updateSection(array $data): TestimonialSection
    {
        $section = $this->getSection();
        $section->update($data);
        
        return $section->fresh();
    }

    /**
     * Get all testimonials
     */
    public function getAllTestimonials()
    {
        return Testimonial::ordered()->get();
    }

    /**
     * Get active testimonials only
     */
    public function getActiveTestimonials()
    {
        return Testimonial::active()->ordered()->get();
    }

    /**
     * Create a new testimonial
     */
    public function create(array $data): Testimonial
    {
        // Process avatar if uploaded
        if (isset($data['avatar']) && $data['avatar'] instanceof UploadedFile) {
            $data['avatar'] = $this->processAvatar($data['avatar']);
        }

        return Testimonial::create($data);
    }

    /**
     * Update a testimonial
     */
    public function update(int $id, array $data): Testimonial
    {
        $testimonial = Testimonial::findOrFail($id);

        // Process avatar if uploaded
        if (isset($data['avatar']) && $data['avatar'] instanceof UploadedFile) {
            // Delete old avatar
            if ($testimonial->avatar && Storage::exists($testimonial->avatar)) {
                Storage::delete($testimonial->avatar);
            }

            $data['avatar'] = $this->processAvatar($data['avatar']);
        } else {
            unset($data['avatar']);
        }

        $testimonial->update($data);

        return $testimonial->fresh();
    }

    /**
     * Delete a testimonial
     */
    public function delete(int $id): bool
    {
        $testimonial = Testimonial::findOrFail($id);
        return $testimonial->delete();
    }

    /**
     * Toggle testimonial status
     */
    public function toggleStatus(int $id): Testimonial
    {
        $testimonial = Testimonial::findOrFail($id);
        
        // Cycle through statuses: active -> disabled -> active
        $newStatus = match($testimonial->status) {
            'active' => 'disabled',
            'disabled' => 'active',
            'pending' => 'active',
            default => 'active',
        };

        $testimonial->update(['status' => $newStatus]);

        return $testimonial->fresh();
    }

    /**
     * Approve a pending testimonial
     */
    public function approve(int $id): Testimonial
    {
        $testimonial = Testimonial::findOrFail($id);
        $testimonial->update(['status' => 'active']);

        return $testimonial->fresh();
    }

    /**
     * Reorder testimonials
     */
    public function reorder(array $orderedIds): void
    {
        foreach ($orderedIds as $index => $id) {
            Testimonial::where('id', $id)->update(['display_order' => $index + 1]);
        }
    }

    /**
     * Process and optimize avatar image
     */
    private function processAvatar(UploadedFile $file): string
    {
        $image = Image::read($file->getRealPath());

        // Get dimensions
        $width = $image->width();
        $height = $image->height();

        // Resize to fit the smallest dimension, then crop to square
        if ($width > $height) {
            $image->scale(height: self::AVATAR_SIZE);
        } else {
            $image->scale(width: self::AVATAR_SIZE);
        }

        // Center crop to exact square
        $image->crop(self::AVATAR_SIZE, self::AVATAR_SIZE, position: 'center');

        // Convert to WEBP with quality optimization
        $quality = 90;
        $tempPath = storage_path('app/temp_avatar.webp');

        do {
            $image->toWebp($quality)->save($tempPath);
            $fileSize = filesize($tempPath);

            if ($fileSize <= self::MAX_AVATAR_SIZE || $quality <= 10) {
                break;
            }

            $quality -= 10;
        } while (true);

        // Store the final image
        $filename = 'testimonials/avatars/' . uniqid() . '.webp';
        Storage::put($filename, file_get_contents($tempPath));

        // Clean up temp file
        @unlink($tempPath);

        return $filename;
    }
}
