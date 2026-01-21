<?php

namespace App\Livewire\Admin\Blog;

use App\Models\BlogPost;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.admin')]
class BlogPostsIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = '';
    public $categoryFilter = '';

    public function updatingSearch() { $this->resetPage(); }
    public function updatingStatusFilter() { $this->resetPage(); }
    public function updatingCategoryFilter() { $this->resetPage(); }

    public function toggleStatus($id)
    {
        $post = BlogPost::findOrFail($id);
        $post->is_active = !$post->is_active;
        $post->save();
    }

    public function toggleFeatured($id)
    {
        $post = BlogPost::findOrFail($id);
        $post->is_featured = !$post->is_featured;
        $post->save();
    }

    public function delete($id)
    {
        BlogPost::findOrFail($id)->delete();
        session()->flash('success', 'Blog post deleted successfully');
    }

    public function render()
    {
        $query = BlogPost::query();
        if ($this->search) {
            $query->where('title', 'like', "%{$this->search}%");
        }
        if ($this->statusFilter !== '') {
            $query->where('is_active', $this->statusFilter === 'active');
        }
        if ($this->categoryFilter) {
            $query->where('category', $this->categoryFilter);
        }

        $posts = $query->orderByDesc('publish_date')->orderByDesc('id')->paginate(15);
        $categories = BlogPost::whereNotNull('category')->distinct()->pluck('category');

        return view('livewire.admin.blog.posts-index', [
            'posts' => $posts,
            'categories' => $categories,
        ]);
    }
}
