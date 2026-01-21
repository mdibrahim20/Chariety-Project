<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">{{ $volunteer ? 'Edit Volunteer' : 'Add New Volunteer' }}</h3>
                    <a href="{{ route('admin.volunteers.index') }}" class="btn btn-secondary">
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
                                    <label for="name" class="form-label">Volunteer Name *</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="name" wire:model="name">
                                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="designation" class="form-label">Designation / Role</label>
                                    <input type="text" class="form-control @error('designation') is-invalid @enderror" 
                                           id="designation" wire:model="designation" placeholder="e.g., Volunteer, Team Lead">
                                    @error('designation') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="profile_photo" class="form-label">Profile Photo (400×500 portrait recommended)</label>
                                    <input type="file" class="form-control @error('profile_photo') is-invalid @enderror" 
                                           id="profile_photo" wire:model="profile_photo" accept="image/*">
                                    @error('profile_photo') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    
                                    @if ($profile_photo)
                                        <div class="mt-2">
                                            <img src="{{ $profile_photo->temporaryUrl() }}" class="img-thumbnail" style="max-height: 200px;">
                                            <button type="button" class="btn btn-sm btn-danger ms-2" wire:click="removeProfilePhoto">Remove</button>
                                        </div>
                                    @elseif ($existing_profile_photo)
                                        <div class="mt-2">
                                            <img src="{{ asset('storage/' . $existing_profile_photo) }}" class="img-thumbnail" style="max-height: 200px;">
                                            <button type="button" class="btn btn-sm btn-danger ms-2" wire:click="deleteProfilePhoto" 
                                                    wire:confirm="Delete this photo?">Delete Existing</button>
                                        </div>
                                    @endif
                                </div>

                                <hr>

                                <h5 class="mb-3">Social Media Links (Optional)</h5>
                                <p class="text-muted small mb-3">Add social media profile URLs. Only links that are provided will be displayed on the frontend.</p>

                                <div class="mb-3">
                                    <label for="facebook_url" class="form-label">
                                        <i class="bi bi-facebook text-primary me-1"></i> Facebook URL
                                    </label>
                                    <input type="url" class="form-control @error('facebook_url') is-invalid @enderror" 
                                           id="facebook_url" wire:model="facebook_url" 
                                           placeholder="https://facebook.com/username">
                                    @error('facebook_url') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="instagram_url" class="form-label">
                                        <i class="bi bi-instagram text-danger me-1"></i> Instagram URL
                                    </label>
                                    <input type="url" class="form-control @error('instagram_url') is-invalid @enderror" 
                                           id="instagram_url" wire:model="instagram_url" 
                                           placeholder="https://instagram.com/username">
                                    @error('instagram_url') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="twitter_url" class="form-label">
                                        <i class="bi bi-twitter text-info me-1"></i> Twitter/X URL
                                    </label>
                                    <input type="url" class="form-control @error('twitter_url') is-invalid @enderror" 
                                           id="twitter_url" wire:model="twitter_url" 
                                           placeholder="https://twitter.com/username">
                                    @error('twitter_url') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="linkedin_url" class="form-label">
                                        <i class="bi bi-linkedin text-primary me-1"></i> LinkedIn URL
                                    </label>
                                    <input type="url" class="form-control @error('linkedin_url') is-invalid @enderror" 
                                           id="linkedin_url" wire:model="linkedin_url" 
                                           placeholder="https://linkedin.com/in/username">
                                    @error('linkedin_url') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="display_order" class="form-label">Display Order</label>
                                    <input type="number" class="form-control" id="display_order" wire:model="display_order" min="0">
                                    <small class="text-muted">Lower numbers appear first</small>
                                </div>

                                <div class="mb-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="is_active" wire:model="is_active">
                                        <label class="form-check-label" for="is_active">Active</label>
                                    </div>
                                    <small class="text-muted">Only active volunteers are shown on the frontend</small>
                                </div>

                                <hr>

                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h6 class="card-title">Social Media Preview</h6>
                                        <p class="small text-muted mb-2">Icons that will be displayed:</p>
                                        <div class="d-flex gap-2 flex-wrap">
                                            @if($facebook_url)
                                                <a href="{{ $facebook_url }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-facebook"></i>
                                                </a>
                                            @endif
                                            @if($instagram_url)
                                                <a href="{{ $instagram_url }}" target="_blank" class="btn btn-sm btn-outline-danger">
                                                    <i class="bi bi-instagram"></i>
                                                </a>
                                            @endif
                                            @if($twitter_url)
                                                <a href="{{ $twitter_url }}" target="_blank" class="btn btn-sm btn-outline-info">
                                                    <i class="bi bi-twitter"></i>
                                                </a>
                                            @endif
                                            @if($linkedin_url)
                                                <a href="{{ $linkedin_url }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-linkedin"></i>
                                                </a>
                                            @endif
                                            @if(!$facebook_url && !$instagram_url && !$twitter_url && !$linkedin_url)
                                                <span class="text-muted small">No social links added yet</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-3">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-1"></i> {{ $volunteer ? 'Update Volunteer' : 'Create Volunteer' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
