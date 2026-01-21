<?php

namespace App\Services;

use App\Models\Volunteer;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class VolunteersService
{
    // Profile photo dimensions (portrait)
    const PHOTO_WIDTH = 400;
    const PHOTO_HEIGHT = 500;
    const MAX_FILE_SIZE = 300 * 1024; // 300 KB

    /**
     * Create or update a volunteer
     */
    public function upsertVolunteer(array $data, ?Volunteer $volunteer = null): Volunteer
    {
        // Sanitize social media URLs
        $data['facebook_url'] = $this->sanitizeUrl($data['facebook_url'] ?? null);
        $data['instagram_url'] = $this->sanitizeUrl($data['instagram_url'] ?? null);
        $data['twitter_url'] = $this->sanitizeUrl($data['twitter_url'] ?? null);
        $data['linkedin_url'] = $this->sanitizeUrl($data['linkedin_url'] ?? null);

        // Process profile photo if provided
        if (isset($data['profile_photo']) && $data['profile_photo'] instanceof UploadedFile) {
            // Delete old photo if exists
            if ($volunteer && $volunteer->profile_photo && Storage::exists($volunteer->profile_photo)) {
                Storage::delete($volunteer->profile_photo);
            }
            $data['profile_photo'] = $this->processProfilePhoto($data['profile_photo']);
        }

        if ($volunteer) {
            $volunteer->update($data);
            return $volunteer;
        }

        return Volunteer::create($data);
    }

    /**
     * Delete a volunteer
     */
    public function deleteVolunteer(Volunteer $volunteer): void
    {
        // Photo is auto-deleted by model's deleting event
        $volunteer->delete();
    }

    /**
     * Reorder volunteers
     */
    public function reorderVolunteers(array $orderedIds): void
    {
        foreach ($orderedIds as $order => $id) {
            Volunteer::where('id', $id)->update(['display_order' => $order]);
        }
    }

    /**
     * Process and optimize profile photo
     */
    private function processProfilePhoto(UploadedFile $file): string
    {
        $manager = new ImageManager(new Driver());
        $image = $manager->read($file->getRealPath());

        // Resize to portrait dimensions (center crop)
        $image->cover(self::PHOTO_WIDTH, self::PHOTO_HEIGHT);

        // Quality optimization loop
        $quality = 90;
        $tempPath = tempnam(sys_get_temp_dir(), 'profile_') . '.webp';
        
        do {
            $image->toWebp($quality)->save($tempPath);
            $fileSize = filesize($tempPath);
            $quality -= 10;
        } while ($fileSize > self::MAX_FILE_SIZE && $quality >= 10);

        $filename = 'volunteers/photos/' . uniqid() . '.webp';
        Storage::put($filename, file_get_contents($tempPath));
        
        unlink($tempPath);
        return $filename;
    }

    /**
     * Sanitize and validate URL
     */
    private function sanitizeUrl(?string $url): ?string
    {
        if (empty($url)) return null;
        
        $url = trim($url);
        
        // Basic URL validation
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            return null;
        }
        
        // Only allow http and https protocols
        $parsed = parse_url($url);
        if (!isset($parsed['scheme']) || !in_array($parsed['scheme'], ['http', 'https'])) {
            return null;
        }
        
        return $url;
    }
}
