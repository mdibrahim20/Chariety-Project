<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">{{ $post ? 'Edit Blog Post' : 'Create New Blog Post' }}</h3>
                    <a href="{{ route('admin.blog.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left me-1"></i> Back to List
                    </a>
                </div>
                <div class="card-body">
                    @if (session()->has('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    @if (session()->has('error'))
                        <div class="alert alert-danger alert-dismissible fade show">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form wire:submit.prevent="save">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="title" class="form-label">Title *</label>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                           id="title" wire:model.live="title">
                                    @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="slug" class="form-label">Slug *</label>
                                    <input type="text" class="form-control @error('slug') is-invalid @enderror" 
                                           id="slug" wire:model="slug">
                                    @error('slug') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="mb-3" wire:ignore>
                                    <label for="content_html" class="form-label">Content *</label>
                                    <textarea class="form-control" id="content_html" wire:model="content_html" rows="15"></textarea>
                                    @error('content_html') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Gallery Images (1200×600 recommended)</label>
                                    <input type="file" class="form-control @error('gallery_images.*') is-invalid @enderror" 
                                           wire:model="gallery_images" multiple accept="image/*">
                                    @error('gallery_images.*') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    
                                    @if (!empty($gallery_images))
                                        <div class="row mt-3">
                                            @foreach($gallery_images as $index => $image)
                                                <div class="col-md-3 mb-3">
                                                    <div class="position-relative">
                                                        <img src="{{ $image->temporaryUrl() }}" class="img-thumbnail">
                                                        <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0" 
                                                                wire:click="removeGalleryImage({{ $index }})">
                                                            <i class="bi bi-x"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif

                                    @if (!empty($existing_images))
                                        <div class="row mt-3">
                                            @foreach($existing_images as $image)
                                                <div class="col-md-3 mb-3">
                                                    <div class="card">
                                                        <img src="{{ asset('storage/' . $image['path_thumb']) }}" class="card-img-top">
                                                        <div class="card-body p-2">
                                                            @if($image['is_featured'])
                                                                <span class="badge bg-success w-100 mb-1">Featured</span>
                                                            @else
                                                                <button type="button" class="btn btn-sm btn-outline-success w-100 mb-1" 
                                                                        wire:click="setFeatured({{ $image['id'] }})">
                                                                    Set as Featured
                                                                </button>
                                                            @endif
                                                            <button type="button" class="btn btn-sm btn-danger w-100" 
                                                                    wire:click="deleteImage({{ $image['id'] }})"
                                                                    wire:confirm="Delete this image?">
                                                                <i class="bi bi-trash"></i> Delete
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="author" class="form-label">Author</label>
                                    <input type="text" class="form-control" id="author" wire:model="author">
                                </div>

                                <div class="mb-3">
                                    <label for="publish_date" class="form-label">Publish Date</label>
                                    <input type="date" class="form-control" id="publish_date" wire:model="publish_date">
                                </div>

                                <div class="mb-3">
                                    <label for="category" class="form-label">Category</label>
                                    <input type="text" class="form-control" id="category" wire:model="category">
                                </div>

                                <div class="mb-3">
                                    <label for="tags" class="form-label">Tags (comma-separated)</label>
                                    <input type="text" class="form-control" id="tags" wire:model="tags" 
                                           placeholder="charity, donation, fundraising">
                                    @error('tags') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>

                                <div class="mb-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="is_active" wire:model="is_active">
                                        <label class="form-check-label" for="is_active">Active</label>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="is_featured" wire:model="is_featured">
                                        <label class="form-check-label" for="is_featured">Featured Post</label>
                                    </div>
                                </div>

                                <hr>

                                <h5>SEO Metadata</h5>
                                <div class="mb-3">
                                    <label for="meta_title" class="form-label">Meta Title</label>
                                    <input type="text" class="form-control" id="meta_title" wire:model="meta_title">
                                </div>

                                <div class="mb-3">
                                    <label for="meta_description" class="form-label">Meta Description</label>
                                    <textarea class="form-control" id="meta_description" wire:model="meta_description" rows="3"></textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="meta_image" class="form-label">Meta Image URL</label>
                                    <input type="text" class="form-control" id="meta_image" wire:model="meta_image">
                                </div>
                            </div>
                        </div>

                        <div class="mt-3">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-1"></i> {{ $post ? 'Update Post' : 'Create Post' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        tinymce.init({
            selector: '#content_html',
            height: 500,
            menubar: false,
            plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
            setup: function(editor) {
                editor.on('change', function() {
                    @this.set('content_html', editor.getContent());
                });
            }
        });
    });
</script>
@endpush
