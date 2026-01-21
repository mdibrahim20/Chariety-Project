<?php

namespace App\Services;

use App\Models\NewsletterSection;
use App\Models\Subscriber;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;

class NewsletterService
{
    // Banner background image - 1170×344 px
    const IMAGE_WIDTH = 1170;
    const IMAGE_HEIGHT = 344;
    const TARGET_SIZE = 136 * 1024; // ~136 KB target
    const MAX_FILE_SIZE = 500 * 1024; // 500 KB hard limit

    /**
     * Get or create the newsletter section (singleton)
     */
    public function getSection(): NewsletterSection
    {
        return NewsletterSection::firstOrCreate(
            ['id' => 1],
            [
                'heading_text' => 'Your Help Can Change Lives',
                'description_text' => 'Subscribe to our newsletter to stay updated',
                'is_active' => true,
            ]
        );
    }

    /**
     * Update the newsletter section
     */
    public function updateSection(array $data): NewsletterSection
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
     */
    private function processBackgroundImage(UploadedFile $file): string
    {
        $image = Image::read($file->getRealPath());

        // Calculate aspect ratios (585:172)
        $targetRatio = self::IMAGE_WIDTH / self::IMAGE_HEIGHT;
        $currentRatio = $image->width() / $image->height();

        // Resize to fit while maintaining aspect ratio, then crop
        if ($currentRatio > $targetRatio) {
            // Image is wider - fit to height
            $image->scale(height: self::IMAGE_HEIGHT);
        } else {
            // Image is taller - fit to width
            $image->scale(width: self::IMAGE_WIDTH);
        }

        // Center crop to exact dimensions
        $image->crop(self::IMAGE_WIDTH, self::IMAGE_HEIGHT, position: 'center');

        // Convert to WEBP with quality optimization
        $quality = 90;
        $tempPath = storage_path('app/temp_newsletter_bg.webp');

        do {
            $image->toWebp($quality)->save($tempPath);
            $fileSize = filesize($tempPath);

            if ($fileSize <= self::MAX_FILE_SIZE || $quality <= 10) {
                break;
            }

            $quality -= 10;
        } while (true);

        // Store the final image
        $filename = 'newsletter/background-' . uniqid() . '.webp';
        Storage::put($filename, file_get_contents($tempPath));

        // Clean up temp file
        @unlink($tempPath);

        return $filename;
    }

    /**
     * Subscribe an email
     */
    public function subscribe(string $email): array
    {
        try {
            // Check if already subscribed
            $existing = Subscriber::where('email', $email)->first();

            if ($existing) {
                if ($existing->status === 'active') {
                    return [
                        'success' => false,
                        'message' => 'This email is already subscribed.',
                    ];
                }

                // Reactivate if unsubscribed
                $existing->update(['status' => 'active']);

                return [
                    'success' => true,
                    'message' => 'Welcome back! You have been resubscribed.',
                ];
            }

            // Create new subscriber
            Subscriber::create([
                'email' => $email,
                'status' => 'active',
            ]);

            return [
                'success' => true,
                'message' => 'Thanks for subscribing!',
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'An error occurred. Please try again.',
            ];
        }
    }

    /**
     * Get all subscribers
     */
    public function getAllSubscribers()
    {
        return Subscriber::recent()->get();
    }

    /**
     * Get active subscribers
     */
    public function getActiveSubscribers()
    {
        return Subscriber::active()->recent()->get();
    }

    /**
     * Delete a subscriber
     */
    public function deleteSubscriber(int $id): bool
    {
        $subscriber = Subscriber::findOrFail($id);
        return $subscriber->delete();
    }

    /**
     * Toggle subscriber status
     */
    public function toggleSubscriberStatus(int $id): Subscriber
    {
        $subscriber = Subscriber::findOrFail($id);
        
        $newStatus = $subscriber->status === 'active' ? 'unsubscribed' : 'active';
        $subscriber->update(['status' => $newStatus]);

        return $subscriber->fresh();
    }

    /**
     * Export subscribers to CSV
     */
    public function exportSubscribers(): string
    {
        $subscribers = Subscriber::orderBy('created_at', 'desc')->get();

        $filename = 'subscribers-' . date('Y-m-d-His') . '.csv';
        $filepath = storage_path('app/exports/' . $filename);

        // Create exports directory if it doesn't exist
        if (!file_exists(storage_path('app/exports'))) {
            mkdir(storage_path('app/exports'), 0755, true);
        }

        $file = fopen($filepath, 'w');

        // Add CSV headers
        fputcsv($file, ['ID', 'Email', 'Status', 'Subscribed At']);

        // Add data
        foreach ($subscribers as $subscriber) {
            fputcsv($file, [
                $subscriber->id,
                $subscriber->email,
                $subscriber->status,
                $subscriber->created_at->format('Y-m-d H:i:s'),
            ]);
        }

        fclose($file);

        return $filepath;
    }
}
