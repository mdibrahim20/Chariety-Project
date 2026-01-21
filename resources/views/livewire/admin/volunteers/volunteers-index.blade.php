<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">Volunteers</h3>
                    <a href="{{ route('admin.volunteers.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle me-1"></i> Add New Volunteer
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
                        <div class="col-md-6">
                            <input type="text" class="form-control" placeholder="Search by name or designation..." wire:model.live="search">
                        </div>
                        <div class="col-md-3">
                            <select class="form-select" wire:model.live="statusFilter">
                                <option value="">All Status</option>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>Order</th>
                                    <th>Photo</th>
                                    <th>Name</th>
                                    <th>Designation</th>
                                    <th>Social Links</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($volunteers as $volunteer)
                                    <tr>
                                        <td>{{ $volunteer->display_order }}</td>
                                        <td>
                                            @if($volunteer->profile_photo)
                                                <img src="{{ $volunteer->profile_photo_url }}" class="img-thumbnail rounded-circle" 
                                                     style="height: 50px; width: 50px; object-fit: cover;">
                                            @else
                                                <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center" 
                                                     style="height: 50px; width: 50px;">
                                                    <i class="bi bi-person text-white" style="font-size: 24px;"></i>
                                                </div>
                                            @endif
                                        </td>
                                        <td><strong>{{ $volunteer->name }}</strong></td>
                                        <td>{{ $volunteer->designation ?? '-' }}</td>
                                        <td>
                                            <div class="d-flex gap-1">
                                                @if($volunteer->facebook_url)
                                                    <i class="bi bi-facebook text-primary"></i>
                                                @endif
                                                @if($volunteer->instagram_url)
                                                    <i class="bi bi-instagram text-danger"></i>
                                                @endif
                                                @if($volunteer->twitter_url)
                                                    <i class="bi bi-twitter text-info"></i>
                                                @endif
                                                @if($volunteer->linkedin_url)
                                                    <i class="bi bi-linkedin text-primary"></i>
                                                @endif
                                                @if(!$volunteer->has_social_links)
                                                    <span class="text-muted">None</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <button wire:click="toggleStatus({{ $volunteer->id }})" 
                                                    class="btn btn-sm btn-{{ $volunteer->is_active ? 'success' : 'secondary' }}">
                                                {{ $volunteer->is_active ? 'Active' : 'Inactive' }}
                                            </button>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.volunteers.edit', $volunteer->id) }}" class="btn btn-sm btn-info">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <button wire:click="delete({{ $volunteer->id }})" 
                                                        class="btn btn-sm btn-danger"
                                                        wire:confirm="Are you sure you want to delete this volunteer?">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">No volunteers found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        {{ $volunteers->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
