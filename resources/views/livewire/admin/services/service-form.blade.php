<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">{{ $serviceModel ? 'Edit Service' : 'Add New Service' }}</h3>
                    <a href="{{ route('admin.services.index') }}" class="btn btn-secondary">
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
                                    <label for="title" class="form-label">Service Title *</label>
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

                                <div class="mb-3">
                                    <label for="short_description" class="form-label">Short Description</label>
                                    <textarea class="form-control @error('short_description') is-invalid @enderror" 
                                              id="short_description" wire:model="short_description" rows="3"></textarea>
                                    @error('short_description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Icon Method</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="iconMethod" id="iconUpload" 
                                               wire:model.live="use_icon_upload" value="1">
                                        <label class="form-check-label" for="iconUpload">Upload Icon (SVG/PNG)</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="iconMethod" id="iconClass" 
                                               wire:model.live="use_icon_upload" value="0">
                                        <label class="form-check-label" for="iconClass">Use Icon Class (e.g., bi-heart)</label>
                                    </div>
                                </div>

                                @if($use_icon_upload)
                                    <div class="mb-3">
                                        <label for="icon" class="form-label">Icon Upload</label>
                                        <input type="file" class="form-control @error('icon') is-invalid @enderror" 
                                               id="icon" wire:model="icon" accept="image/svg+xml,image/png,image/jpeg">
                                        @error('icon') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        
                                        @if ($icon)
                                            <div class="mt-2">
                                                <img src="{{ $icon->temporaryUrl() }}" class="img-thumbnail" style="max-height: 100px;">
                                                <button type="button" class="btn btn-sm btn-danger ms-2" wire:click="removeIcon">Remove</button>
                                            </div>
                                        @elseif ($existing_icon && str_starts_with($existing_icon, 'services/'))
                                            <div class="mt-2">
                                                <img src="{{ asset('storage/' . $existing_icon) }}" class="img-thumbnail" style="max-height: 100px;">
                                                <button type="button" class="btn btn-sm btn-danger ms-2" wire:click="deleteIcon" 
                                                        wire:confirm="Delete this icon?">Delete Existing</button>
                                            </div>
                                        @endif
                                    </div>
                                @else
                                    <div class="mb-3">
                                        <label for="icon_class" class="form-label">Icon Class Name</label>
                                        <input type="text" class="form-control @error('icon_class') is-invalid @enderror" 
                                               id="icon_class" wire:model="icon_class" 
                                               placeholder="e.g., bi-heart, fas fa-home">
                                        @error('icon_class') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        @if($icon_class)
                                            <div class="mt-2">
                                                <span>Preview: <i class="{{ $icon_class }}" style="font-size: 32px;"></i></span>
                                            </div>
                                        @endif
                                    </div>
                                @endif

                                <div class="mb-3">
                                    <label for="card_image" class="form-label">Card Image (400×300 recommended)</label>
                                    <input type="file" class="form-control @error('card_image') is-invalid @enderror" 
                                           id="card_image" wire:model="card_image" accept="image/*">
                                    @error('card_image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    
                                    @if ($card_image)
                                        <div class="mt-2">
                                            <img src="{{ $card_image->temporaryUrl() }}" class="img-thumbnail" style="max-height: 150px;">
                                            <button type="button" class="btn btn-sm btn-danger ms-2" wire:click="removeCardImage">Remove</button>
                                        </div>
                                    @elseif ($existing_card_image)
                                        <div class="mt-2">
                                            <img src="{{ asset('storage/' . $existing_card_image) }}" class="img-thumbnail" style="max-height: 150px;">
                                            <button type="button" class="btn btn-sm btn-danger ms-2" wire:click="deleteCardImage" 
                                                    wire:confirm="Delete this image?">Delete Existing</button>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="button_text" class="form-label">Button Text</label>
                                    <input type="text" class="form-control" id="button_text" wire:model="button_text">
                                </div>

                                <div class="mb-3">
                                    <label for="button_link" class="form-label">Button Link</label>
                                    <input type="text" class="form-control" id="button_link" wire:model="button_link" 
                                           placeholder="/contact or https://example.com">
                                </div>

                                <div class="mb-3">
                                    <label for="display_order" class="form-label">Display Order</label>
                                    <input type="number" class="form-control" id="display_order" wire:model="display_order" min="0">
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
                                        <label class="form-check-label" for="is_featured">Featured/Highlighted</label>
                                    </div>
                                    <small class="text-muted">Featured services show with highlighted style</small>
                                </div>
                            </div>
                        </div>

                        <div class="mt-3">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-1"></i> {{ $serviceModel ? 'Update Service' : 'Create Service' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
