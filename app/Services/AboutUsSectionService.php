<?php

namespace App\Services;

use App\Models\AboutUsSection;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;

class AboutUsSectionService
{
    // Image 1 (Main large image) - 416×659 px
    const IMAGE1_WIDTH = 416;
    const IMAGE1_HEIGHT = 659;
    const IMAGE1_TARGET_SIZE = 108 * 1024; // ~108 KB target
    
    // Image 2 (Small image) - 196×312 px
    const IMAGE2_WIDTH = 196;
    const IMAGE2_HEIGHT = 312;
    const IMAGE2_TARGET_SIZE = 27.4 * 1024; // ~27.4 KB target
    
    const MAX_FILE_SIZE = 500 * 1024; // 500 KB hard limit

    /**
     * Get or create the about us section (singleton pattern)
     */
    public function getSection(): AboutUsSection
    {
        return AboutUsSection::firstOrCreate(
            ['id' => 1],
            [
                'main_heading' => 'About Our Organization',
                'is_active' => true,
            ]
        );
    }

    /**
     * Update the about us section
     */
    public function update(array $data): AboutUsSection
    {
        $section = $this->getSection();
        
        // Process Image 1 if uploaded
        if (isset($data['image1']) && $data['image1'] instanceof UploadedFile) {
            // Delete old image1
            if ($section->image1 && Storage::exists($section->image1)) {
                Storage::delete($section->image1);
            }
            
            $data['image1'] = $this->processImage1($data['image1']);
        } else {
            unset($data['image1']);
        }
        
        // Process Image 2 if uploaded
        if (isset($data['image2']) && $data['image2'] instanceof UploadedFile) {
            // Delete old image2
            if ($section->image2 && Storage::exists($section->image2)) {
                Storage::delete($section->image2);
            }
            
            $data['image2'] = $this->processImage2($data['image2']);
        } else {
            unset($data['image2']);
        }
        
        // Process Feature 1 Icon if uploaded
        if (isset($data['feature1_icon']) && $data['feature1_icon'] instanceof UploadedFile) {
            // Delete old icon
            if ($section->feature1_icon && Storage::exists($section->feature1_icon)) {
                Storage::delete($section->feature1_icon);
            }
            
            $data['feature1_icon'] = $this->processIcon($data['feature1_icon'], 'feature1');
        } else {
            unset($data['feature1_icon']);
        }
        
        // Process Feature 2 Icon if uploaded
        if (isset($data['feature2_icon']) && $data['feature2_icon'] instanceof UploadedFile) {
            // Delete old icon
            if ($section->feature2_icon && Storage::exists($section->feature2_icon)) {
                Storage::delete($section->feature2_icon);
            }
            
            $data['feature2_icon'] = $this->processIcon($data['feature2_icon'], 'feature2');
        } else {
            unset($data['feature2_icon']);
        }
        
        $section->update($data);
        
        return $section->fresh();
    }

    /**
     * Process and optimize Image 1 (Main large image - 416×659)
     */
    private function processImage1(UploadedFile $file): string
    {
        $image = Image::read($file->getRealPath());
        
        // Calculate aspect ratios
        $targetRatio = self::IMAGE1_WIDTH / self::IMAGE1_HEIGHT;
        $currentRatio = $image->width() / $image->height();
        
        // Resize to fit while maintaining aspect ratio, then crop
        if ($currentRatio > $targetRatio) {
            // Image is wider - fit to height
            $image->scale(height: self::IMAGE1_HEIGHT);
        } else {
            // Image is taller - fit to width
            $image->scale(width: self::IMAGE1_WIDTH);
        }
        
        // Center crop to exact dimensions
        $image->crop(self::IMAGE1_WIDTH, self::IMAGE1_HEIGHT, position: 'center');
        
        // Convert to WEBP with quality optimization
        $quality = 90;
        $tempPath = storage_path('app/temp_image1.webp');
        
        do {
            $image->toWebp($quality)->save($tempPath);
            $fileSize = filesize($tempPath);
            
            if ($fileSize <= self::MAX_FILE_SIZE || $quality <= 10) {
                break;
            }
            
            $quality -= 10;
        } while (true);
        
        // Store the final image
        $filename = 'about-us/image1-' . uniqid() . '.webp';
        Storage::put($filename, file_get_contents($tempPath));
        
        // Clean up temp file
        @unlink($tempPath);
        
        return $filename;
    }

    /**
     * Process and optimize Image 2 (Small image - 196×312)
     */
    private function processImage2(UploadedFile $file): string
    {
        $image = Image::read($file->getRealPath());
        
        // Calculate aspect ratios
        $targetRatio = self::IMAGE2_WIDTH / self::IMAGE2_HEIGHT;
        $currentRatio = $image->width() / $image->height();
        
        // Resize to fit while maintaining aspect ratio, then crop
        if ($currentRatio > $targetRatio) {
            // Image is wider - fit to height
            $image->scale(height: self::IMAGE2_HEIGHT);
        } else {
            // Image is taller - fit to width
            $image->scale(width: self::IMAGE2_WIDTH);
        }
        
        // Center crop to exact dimensions
        $image->crop(self::IMAGE2_WIDTH, self::IMAGE2_HEIGHT, position: 'center');
        
        // Convert to WEBP with quality optimization
        $quality = 90;
        $tempPath = storage_path('app/temp_image2.webp');
        
        do {
            $image->toWebp($quality)->save($tempPath);
            $fileSize = filesize($tempPath);
            
            if ($fileSize <= self::MAX_FILE_SIZE || $quality <= 10) {
                break;
            }
            
            $quality -= 10;
        } while (true);
        
        // Store the final image
        $filename = 'about-us/image2-' . uniqid() . '.webp';
        Storage::put($filename, file_get_contents($tempPath));
        
        // Clean up temp file
        @unlink($tempPath);
        
        return $filename;
    }

    /**
     * Process and store icon (SVG or image file)
     */
    private function processIcon(UploadedFile $file, string $prefix): string
    {
        $extension = $file->getClientOriginalExtension();
        $filename = 'about-us/icons/' . $prefix . '-' . uniqid() . '.' . $extension;
        
        // If it's an SVG, just store it
        if ($extension === 'svg') {
            Storage::put($filename, file_get_contents($file->getRealPath()));
            return $filename;
        }
        
        // For other image formats, resize to reasonable icon size and convert to WEBP
        $image = Image::read($file->getRealPath());
        $image->scale(width: 64); // Max 64px width for icons
        
        $tempPath = storage_path('app/temp_icon.webp');
        $image->toWebp(90)->save($tempPath);
        
        $filename = 'about-us/icons/' . $prefix . '-' . uniqid() . '.webp';
        Storage::put($filename, file_get_contents($tempPath));
        
        @unlink($tempPath);
        
        return $filename;
    }

    /**
     * Toggle section status
     */
    public function toggleStatus(): AboutUsSection
    {
        $section = $this->getSection();
        $section->update(['is_active' => !$section->is_active]);
        
        return $section->fresh();
    }
}
