<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">Blog Posts</h3>
                    <a href="{{ route('admin.blog.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle me-1"></i> Create New Post
                    </a>
                </div>
                <div class="card-body">
                    @if (session()->has('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <input type="text" class="form-control" placeholder="Search by title..." wire:model.live="search">
                        </div>
                        <div class="col-md-3">
                            <select class="form-select" wire:model.live="statusFilter">
                                <option value="">All Status</option>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select class="form-select" wire:model.live="categoryFilter">
                                <option value="">All Categories</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat }}">{{ $cat }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>Featured</th>
                                    <th>Title</th>
                                    <th>Category</th>
                                    <th>Author</th>
                                    <th>Publish Date</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($posts as $post)
                                    <tr>
                                        <td>
                                            @if($post->featured_image)
                                                <img src="{{ $post->featuredImage->thumb_url }}" class="img-thumbnail" style="height: 40px; width: 60px; object-fit: cover;">
                                            @else
                                                <span class="badge bg-secondary">No Image</span>
                                            @endif
                                        </td>
                                        <td>
                                            <strong>{{ $post->title }}</strong>
                                            @if($post->is_featured)
                                                <span class="badge bg-warning text-dark ms-1">Featured</span>
                                            @endif
                                        </td>
                                        <td>{{ $post->category ?? '-' }}</td>
                                        <td>{{ $post->author ?? '-' }}</td>
                                        <td>{{ $post->publish_date?->format('M d, Y') ?? '-' }}</td>
                                        <td>
                                            <button wire:click="toggleStatus({{ $post->id }})" 
                                                    class="btn btn-sm btn-{{ $post->is_active ? 'success' : 'secondary' }}">
                                                {{ $post->is_active ? 'Active' : 'Inactive' }}
                                            </button>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.blog.edit', $post->id) }}" class="btn btn-sm btn-info">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <button wire:click="toggleFeatured({{ $post->id }})" 
                                                        class="btn btn-sm btn-{{ $post->is_featured ? 'warning' : 'outline-warning' }}">
                                                    <i class="bi bi-star{{ $post->is_featured ? '-fill' : '' }}"></i>
                                                </button>
                                                <button wire:click="delete({{ $post->id }})" 
                                                        class="btn btn-sm btn-danger"
                                                        wire:confirm="Are you sure you want to delete this post?">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">No blog posts found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        {{ $posts->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
