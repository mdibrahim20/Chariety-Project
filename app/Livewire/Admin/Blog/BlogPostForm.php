<?php

namespace App\Livewire\Admin\Blog;

use App\Models\BlogPost;
use App\Models\BlogImage;
use App\Services\BlogService;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.admin')]
class BlogPostForm extends Component
{
    use WithFileUploads;

    protected BlogService $service;

    public ?BlogPost $post = null;
    public $title;
    public $slug;
    public $content_html;
    public $author;
    public $publish_date;
    public $category;
    public $is_active = true;
    public $is_featured = false;
    public $meta_title;
    public $meta_description;
    public $meta_image;
    public $tags = '';
    public $gallery_images = [];
    public $existing_images = [];

    public function boot(BlogService $service): void
    {
        $this->service = $service;
    }

    public function mount($id = null): void
    {
        if ($id) {
            $this->post = BlogPost::with(['images', 'tags'])->findOrFail($id);
            $this->title = $this->post->title;
            $this->slug = $this->post->slug;
            $this->content_html = $this->post->content_html;
            $this->author = $this->post->author;
            $this->publish_date = $this->post->publish_date?->format('Y-m-d');
            $this->category = $this->post->category;
            $this->is_active = $this->post->is_active;
            $this->is_featured = $this->post->is_featured;
            $this->meta_title = $this->post->meta_title;
            $this->meta_description = $this->post->meta_description;
            $this->meta_image = $this->post->meta_image;
            $this->tags = $this->post->tags->pluck('name')->implode(', ');
            $this->existing_images = $this->post->images->sortBy('position')->toArray();
        } else {
            $this->publish_date = now()->format('Y-m-d');
        }
    }

    public function updatedTitle()
    {
        if (!$this->post) {
            $this->slug = \Str::slug($this->title);
        }
    }

    public function save()
    {
        try {
            $this->validate([
                'title' => 'required|string|max:255',
                'slug' => 'required|string|max:255|unique:blog_posts,slug,' . ($this->post->id ?? 'NULL'),
                'content_html' => 'required|string',
                'author' => 'nullable|string|max:255',
                'publish_date' => 'nullable|date',
                'category' => 'nullable|string|max:255',
                'meta_title' => 'nullable|string|max:255',
                'meta_description' => 'nullable|string',
                'meta_image' => 'nullable|string',
                'tags' => 'nullable|string',
                'gallery_images.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:10240',
            ]);

            $data = [
                'title' => $this->title,
                'slug' => $this->slug,
                'content_html' => $this->content_html,
                'author' => $this->author,
                'publish_date' => $this->publish_date,
                'category' => $this->category,
                'is_active' => (bool) $this->is_active,
                'is_featured' => (bool) $this->is_featured,
                'meta_title' => $this->meta_title,
                'meta_description' => $this->meta_description,
                'meta_image' => $this->meta_image,
            ];

            $tagNames = $this->tags ? array_map('trim', explode(',', $this->tags)) : [];

            $savedPost = $this->service->upsertPost($data, $this->post);
            $this->service->syncTags($savedPost, $tagNames);

            if (!empty($this->gallery_images)) {
                $this->service->addGalleryImages($savedPost, $this->gallery_images);
            }

            session()->flash('success', 'Blog post saved successfully!');
            $this->redirect(route('admin.blog.edit', $savedPost->id));
        } catch (\Exception $e) {
            \Log::error('Blog post save error: ' . $e->getMessage());
            session()->flash('error', 'Failed to save: ' . $e->getMessage());
        }
    }

    public function setFeatured($imageId): void
    {
        if ($this->post) {
            $this->service->setFeaturedImage($this->post, $imageId);
            $this->mount($this->post->id);
            session()->flash('success', 'Featured image updated!');
        }
    }

    public function deleteImage($imageId): void
    {
        try {
            $image = BlogImage::findOrFail($imageId);
            $this->service->deleteImage($image);
            $this->mount($this->post->id);
            session()->flash('success', 'Image deleted successfully');
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to delete image');
        }
    }

    public function removeGalleryImage($index): void
    {
        unset($this->gallery_images[$index]);
        $this->gallery_images = array_values($this->gallery_images);
    }

    public function render()
    {
        return view('livewire.admin.blog.post-form');
    }
}
