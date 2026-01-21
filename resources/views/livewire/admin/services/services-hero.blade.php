<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Services Hero Section Settings</h3>
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
                            <div class="col-md-6 mb-3">
                                <label for="page_title" class="form-label">Page Title *</label>
                                <input type="text" class="form-control @error('page_title') is-invalid @enderror" 
                                       id="page_title" wire:model="page_title">
                                @error('page_title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-3 mb-3">
                                <label for="breadcrumb_home_label" class="form-label">Breadcrumb Home Label</label>
                                <input type="text" class="form-control" id="breadcrumb_home_label" wire:model="breadcrumb_home_label">
                            </div>

                            <div class="col-md-3 mb-3">
                                <label for="breadcrumb_current_label" class="form-label">Breadcrumb Current Label</label>
                                <input type="text" class="form-control" id="breadcrumb_current_label" wire:model="breadcrumb_current_label">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="background_image" class="form-label">Background Image (1920×600 recommended)</label>
                                <input type="file" class="form-control @error('background_image') is-invalid @enderror" 
                                       id="background_image" wire:model="background_image" accept="image/*">
                                @error('background_image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                
                                @if ($background_image)
                                    <div class="mt-2">
                                        <img src="{{ $background_image->temporaryUrl() }}" class="img-thumbnail" style="max-height: 150px;">
                                        <button type="button" class="btn btn-sm btn-danger ms-2" wire:click="removeBackgroundImage">Remove</button>
                                    </div>
                                @elseif ($existing_background_image)
                                    <div class="mt-2">
                                        <img src="{{ asset('storage/' . $existing_background_image) }}" class="img-thumbnail" style="max-height: 150px;">
                                        <button type="button" class="btn btn-sm btn-danger ms-2" wire:click="deleteBackgroundImage" 
                                                wire:confirm="Are you sure you want to delete this image?">Delete Existing</button>
                                    </div>
                                @endif
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label">Overlay Settings</label>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="overlay_enabled" wire:model.live="overlay_enabled">
                                    <label class="form-check-label" for="overlay_enabled">Enable Overlay</label>
                                </div>
                                @if ($overlay_enabled)
                                    <div class="mt-2">
                                        <label for="overlay_opacity" class="form-label">Opacity: {{ $overlay_opacity }}%</label>
                                        <input type="range" class="form-range" id="overlay_opacity" wire:model.live="overlay_opacity" min="0" max="100">
                                    </div>
                                @endif
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label">Status</label>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="is_active" wire:model="is_active">
                                    <label class="form-check-label" for="is_active">Active</label>
                                </div>
                            </div>
                        </div>

                        <div class="mt-3">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-1"></i> Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
