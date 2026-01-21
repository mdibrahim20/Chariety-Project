<?php

namespace App\Services;

use App\Models\Service;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class ServicesService
{
    // Card image dimensions
    const CARD_WIDTH = 400;
    const CARD_HEIGHT = 300;
    const MAX_FILE_SIZE = 300 * 1024; // 300 KB

    /**
     * Create or update a service
     */
    public function upsertService(array $data, ?Service $service = null): Service
    {
        // Process icon upload if provided
        if (isset($data['icon']) && $data['icon'] instanceof UploadedFile) {
            // Delete old icon if exists
            if ($service && $service->icon && Storage::exists($service->icon)) {
                Storage::delete($service->icon);
            }
            $data['icon'] = $this->processIcon($data['icon']);
        } elseif (isset($data['icon_class'])) {
            // If using icon class instead of upload
            $data['icon'] = $data['icon_class'];
            unset($data['icon_class']);
        }

        // Process card image if provided
        if (isset($data['card_image']) && $data['card_image'] instanceof UploadedFile) {
            // Delete old card image if exists
            if ($service && $service->card_image && Storage::exists($service->card_image)) {
                Storage::delete($service->card_image);
            }
            $data['card_image'] = $this->processCardImage($data['card_image']);
        }

        if ($service) {
            $service->update($data);
            return $service;
        }

        return Service::create($data);
    }

    /**
     * Delete a service
     */
    public function deleteService(Service $service): void
    {
        // Files are auto-deleted by model's deleting event
        $service->delete();
    }

    /**
     * Reorder services
     */
    public function reorderServices(array $orderedIds): void
    {
        foreach ($orderedIds as $order => $id) {
            Service::where('id', $id)->update(['display_order' => $order]);
        }
    }

    /**
     * Process and optimize icon (SVG or image)
     */
    private function processIcon(UploadedFile $file): string
    {
        $extension = $file->getClientOriginalExtension();
        
        // If SVG, just store it
        if (strtolower($extension) === 'svg') {
            $filename = 'services/icons/' . uniqid() . '.svg';
            Storage::put($filename, file_get_contents($file->getRealPath()));
            return $filename;
        }

        // Otherwise, process as image
        $manager = new ImageManager(new Driver());
        $image = $manager->read($file->getRealPath());

        // Resize to square icon
        $image->cover(100, 100);

        // Convert to PNG (for transparency support)
        $tempPath = tempnam(sys_get_temp_dir(), 'icon_') . '.png';
        $image->toPng()->save($tempPath);

        $filename = 'services/icons/' . uniqid() . '.png';
        Storage::put($filename, file_get_contents($tempPath));
        
        unlink($tempPath);
        return $filename;
    }

    /**
     * Process and optimize card image
     */
    private function processCardImage(UploadedFile $file): string
    {
        $manager = new ImageManager(new Driver());
        $image = $manager->read($file->getRealPath());

        // Resize to card dimensions (center crop)
        $image->cover(self::CARD_WIDTH, self::CARD_HEIGHT);

        // Quality optimization loop
        $quality = 90;
        $tempPath = tempnam(sys_get_temp_dir(), 'card_') . '.webp';
        
        do {
            $image->toWebp($quality)->save($tempPath);
            $fileSize = filesize($tempPath);
            $quality -= 10;
        } while ($fileSize > self::MAX_FILE_SIZE && $quality >= 10);

        $filename = 'services/cards/' . uniqid() . '.webp';
        Storage::put($filename, file_get_contents($tempPath));
        
        unlink($tempPath);
        return $filename;
    }
}
