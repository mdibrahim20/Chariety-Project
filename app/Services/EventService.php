<?php

namespace App\Services;

use App\Models\Event;
use App\Models\EventImage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;

class EventService
{
    // Image sizes
    const HERO_WIDTH = 1920;
    const HERO_HEIGHT = 600;
    const CARD_WIDTH = 370;
    const CARD_HEIGHT = 240;

    const MAX_FILE_SIZE = 500 * 1024; // 500KB

    /** Create or update Event */
    public function upsertEvent(array $data, ?Event $event = null): Event
    {
        // Sanitize content_html
        if (isset($data['content_html'])) {
            $data['content_html'] = $this->sanitizeHtml($data['content_html']);
        }

        if (!$event) {
            $event = new Event();
        }

        $event->fill($data);
        $event->save();

        return $event->fresh();
    }

    /** Process and attach gallery images */
    public function addGalleryImages(Event $event, array $files): void
    {
        DB::transaction(function () use ($event, $files) {
            foreach ($files as $index => $file) {
                if (!$file instanceof UploadedFile) continue;

                [$pathFeatured, $pathThumb] = $this->processImagePair($file);

                EventImage::create([
                    'event_id' => $event->id,
                    'path_featured' => $pathFeatured,
                    'path_thumb' => $pathThumb,
                    'position' => $event->images()->count() + $index,
                ]);
            }
        });
    }

    /** Reorder images */
    public function reorderImages(Event $event, array $orderedIds): void
    {
        foreach ($orderedIds as $position => $id) {
            EventImage::where('id', $id)->where('event_id', $event->id)->update(['position' => $position]);
        }
    }

    /** Set featured image */
    public function setFeaturedImage(Event $event, int $imageId): void
    {
        $image = EventImage::where('id', $imageId)->where('event_id', $event->id)->firstOrFail();
        // Reset flags
        EventImage::where('event_id', $event->id)->update(['is_featured' => false]);
        $image->update(['is_featured' => true]);
        $event->update(['featured_image_id' => $image->id]);
    }

    /** Delete image */
    public function deleteImage(EventImage $image): void
    {
        $image->delete();
    }

    /** Sanitize HTML content to avoid XSS */
    public function sanitizeHtml(string $html): string
    {
        // Basic sanitization: remove script/style tags and dangerous attributes
        $dom = new \DOMDocument('1.0', 'UTF-8');
        libxml_use_internal_errors(true);
        $dom->loadHTML('<?xml encoding="utf-8" ?>' . $html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        libxml_clear_errors();

        // Remove script and style tags
        while (($scripts = $dom->getElementsByTagName('script'))->length) {
            $scripts->item(0)->parentNode->removeChild($scripts->item(0));
        }
        while (($styles = $dom->getElementsByTagName('style'))->length) {
            $styles->item(0)->parentNode->removeChild($styles->item(0));
        }

        $xpath = new \DOMXPath($dom);
        foreach ($xpath->query('//*') as $node) {
            // Remove on* attributes
            if ($node->hasAttributes()) {
                foreach (iterator_to_array($node->attributes) as $attr) {
                    if (stripos($attr->name, 'on') === 0) {
                        $node->removeAttribute($attr->name);
                        continue;
                    }
                    // Disallow javascript: in href/src
                    if (in_array($attr->name, ['href','src']) && stripos($attr->value, 'javascript:') === 0) {
                        $node->removeAttribute($attr->name);
                    }
                }
            }
        }

        return $dom->saveHTML();
    }

    /** Process single image into hero and card sizes */
    private function processImagePair(UploadedFile $file): array
    {
        $pathFeatured = $this->processImage($file, self::HERO_WIDTH, self::HERO_HEIGHT, 'events/hero-');
        $pathThumb = $this->processImage($file, self::CARD_WIDTH, self::CARD_HEIGHT, 'events/thumb-');
        return [$pathFeatured, $pathThumb];
    }

    /** Process and store WEBP image with center-crop and compression */
    private function processImage(UploadedFile $file, int $targetW, int $targetH, string $prefix): string
    {
        $image = Image::read($file->getRealPath());
        $targetRatio = $targetW / $targetH;
        $currentRatio = $image->width() / $image->height();

        if ($currentRatio > $targetRatio) {
            $image->scale(height: $targetH);
        } else {
            $image->scale(width: $targetW);
        }

        $image->crop($targetW, $targetH, position: 'center');

        $quality = 90;
        $tempPath = storage_path('app/temp_event_img.webp');
        do {
            $image->toWebp($quality)->save($tempPath);
            $size = filesize($tempPath);
            if ($size <= self::MAX_FILE_SIZE || $quality <= 10) break;
            $quality -= 10;
        } while (true);

        $filename = 'events/' . $prefix . uniqid() . '.webp';
        Storage::put($filename, file_get_contents($tempPath));
        @unlink($tempPath);
        return $filename;
    }

    /** Process meta image (for SEO/social) */
    public function processMetaImage(UploadedFile $file): string
    {
        // Use 1200x630 as common OpenGraph size
        return $this->processImage($file, 1200, 630, 'events/meta-');
    }

    /** Helper used by form to process a single file into pair (compat) */
    public function addGalleryImagesPlaceholderProcess(UploadedFile $file): array
    {
        return [
            $this->processImage($file, self::HERO_WIDTH, self::HERO_HEIGHT, 'events/hero-'),
            $this->processImage($file, self::CARD_WIDTH, self::CARD_HEIGHT, 'events/thumb-'),
        ];
    }
}
