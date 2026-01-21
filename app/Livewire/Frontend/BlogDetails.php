<?php

namespace App\Livewire\Frontend;

use App\Models\BlogPost;
use App\Models\BlogHeroSection;
use App\Models\BlogTag;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class BlogDetails extends Component
{
    public ?BlogPost $post = null;
    public ?BlogHeroSection $hero = null;
    public $recentPosts = [];
    public $popularTags = [];

    public function mount($slug): void
    {
        $this->post = BlogPost::with(['images', 'tags', 'featuredImage'])
            ->where('slug', $slug)
            ->active()
            ->firstOrFail();

        $this->hero = BlogHeroSection::active()->first();

        $this->recentPosts = BlogPost::with('featuredImage')
            ->active()
            ->where('id', '!=', $this->post->id)
            ->orderByDesc('publish_date')
            ->limit(5)
            ->get();

        $this->popularTags = BlogTag::withCount('blogPosts')
            ->having('blog_posts_count', '>', 0)
            ->orderByDesc('blog_posts_count')
            ->limit(10)
            ->get();
    }

    public function render()
    {
        return view('livewire.frontend.blog-details');
    }
}
