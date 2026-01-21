<?php

namespace App\Services;

use App\Models\BlogPost;
use App\Models\BlogImage;
use App\Models\BlogTag;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;

class BlogService
{
    // Image sizes
    const LARGE_WIDTH = 1200;
    const LARGE_HEIGHT = 600;
    const MEDIUM_WIDTH = 800;
    const MEDIUM_HEIGHT = 400;
    const THUMB_WIDTH = 370;
    const THUMB_HEIGHT = 240;
    const MAX_FILE_SIZE = 500 * 1024;

    public function upsertPost(array $data, ?BlogPost $post = null): BlogPost
    {
        // Sanitize HTML content
        if (isset($data['content_html'])) {
            $data['content_html'] = $this->sanitizeHtml($data['content_html']);
        }

        if (!$post) {
            $post = new BlogPost();
        }

        // Handle tags separately
        $tags = $data['tags'] ?? [];
        unset($data['tags']);

        $post->fill($data);
        $post->save();

        // Sync tags
        if (!empty($tags)) {
            $this->syncTags($post, $tags);
        }

        return $post->fresh();
    }

    public function addGalleryImages(BlogPost $post, array $files): void
    {
        DB::transaction(function () use ($post, $files) {
            foreach ($files as $index => $file) {
                if (!$file instanceof UploadedFile) continue;

                [$large, $medium, $thumb] = $this->processImageTriple($file);

                BlogImage::create([
                    'blog_post_id' => $post->id,
                    'path_large' => $large,
                    'path_medium' => $medium,
                    'path_thumb' => $thumb,
                    'position' => $post->images()->count() + $index,
                ]);
            }
        });
    }

    public function setFeaturedImage(BlogPost $post, int $imageId): void
    {
        $image = BlogImage::where('id', $imageId)->where('blog_post_id', $post->id)->firstOrFail();
        BlogImage::where('blog_post_id', $post->id)->update(['is_featured' => false]);
        $image->update(['is_featured' => true]);
        $post->update(['featured_image_id' => $image->id]);
    }

    public function deleteImage(BlogImage $image): void
    {
        $image->delete();
    }

    public function syncTags(BlogPost $post, array $tagNames): void
    {
        $tagIds = [];
        foreach ($tagNames as $name) {
            $name = trim($name);
            if (empty($name)) continue;
            $tag = BlogTag::firstOrCreate(['name' => $name]);
            $tagIds[] = $tag->id;
        }
        $post->tags()->sync($tagIds);
    }

    public function sanitizeHtml(string $html): string
    {
        $dom = new \DOMDocument('1.0', 'UTF-8');
        libxml_use_internal_errors(true);
        $dom->loadHTML('<?xml encoding="utf-8" ?>' . $html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        libxml_clear_errors();

        while (($scripts = $dom->getElementsByTagName('script'))->length) {
            $scripts->item(0)->parentNode->removeChild($scripts->item(0));
        }
        while (($styles = $dom->getElementsByTagName('style'))->length) {
            $styles->item(0)->parentNode->removeChild($styles->item(0));
        }

        $xpath = new \DOMXPath($dom);
        foreach ($xpath->query('//*') as $node) {
            if ($node->hasAttributes()) {
                foreach (iterator_to_array($node->attributes) as $attr) {
                    if (stripos($attr->name, 'on') === 0) {
                        $node->removeAttribute($attr->name);
                        continue;
                    }
                    if (in_array($attr->name, ['href','src']) && stripos($attr->value, 'javascript:') === 0) {
                        $node->removeAttribute($attr->name);
                    }
                }
            }
        }

        return $dom->saveHTML();
    }

    private function processImageTriple(UploadedFile $file): array
    {
        return [
            $this->processImage($file, self::LARGE_WIDTH, self::LARGE_HEIGHT, 'blog/large-'),
            $this->processImage($file, self::MEDIUM_WIDTH, self::MEDIUM_HEIGHT, 'blog/medium-'),
            $this->processImage($file, self::THUMB_WIDTH, self::THUMB_HEIGHT, 'blog/thumb-'),
        ];
    }

    private function processImage(UploadedFile $file, int $w, int $h, string $prefix): string
    {
        $image = Image::read($file->getRealPath());
        $ratio = $w / $h;
        $current = $image->width() / $image->height();

        if ($current > $ratio) {
            $image->scale(height: $h);
        } else {
            $image->scale(width: $w);
        }

        $image->crop($w, $h, position: 'center');

        $quality = 90;
        $temp = storage_path('app/temp_blog.webp');
        do {
            $image->toWebp($quality)->save($temp);
            $size = filesize($temp);
            if ($size <= self::MAX_FILE_SIZE || $quality <= 10) break;
            $quality -= 10;
        } while (true);

        $filename = $prefix . uniqid() . '.webp';
        Storage::put($filename, file_get_contents($temp));
        @unlink($temp);
        return $filename;
    }
}
