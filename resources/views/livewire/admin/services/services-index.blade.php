<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">Services</h3>
                    <a href="{{ route('admin.services.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle me-1"></i> Add New Service
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
                            <input type="text" class="form-control" placeholder="Search by title..." wire:model.live="search">
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
                                    <th>Icon/Image</th>
                                    <th>Title</th>
                                    <th>Short Description</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($services as $service)
                                    <tr>
                                        <td>{{ $service->display_order }}</td>
                                        <td>
                                            @if($service->card_image)
                                                <img src="{{ $service->card_image_url }}" class="img-thumbnail" 
                                                     style="height: 50px; width: 70px; object-fit: cover;">
                                            @elseif($service->icon_url)
                                                <img src="{{ $service->icon_url }}" style="height: 40px; width: 40px;">
                                            @elseif($service->icon)
                                                <i class="{{ $service->icon }}" style="font-size: 24px;"></i>
                                            @else
                                                <span class="badge bg-secondary">No Icon</span>
                                            @endif
                                        </td>
                                        <td>
                                            <strong>{{ $service->title }}</strong>
                                            @if($service->is_featured)
                                                <span class="badge bg-warning text-dark ms-1">Featured</span>
                                            @endif
                                        </td>
                                        <td>{{ \Str::limit($service->short_description, 50) }}</td>
                                        <td>
                                            <button wire:click="toggleStatus({{ $service->id }})" 
                                                    class="btn btn-sm btn-{{ $service->is_active ? 'success' : 'secondary' }}">
                                                {{ $service->is_active ? 'Active' : 'Inactive' }}
                                            </button>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.services.edit', $service->id) }}" class="btn btn-sm btn-info">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <button wire:click="toggleFeatured({{ $service->id }})" 
                                                        class="btn btn-sm btn-{{ $service->is_featured ? 'warning' : 'outline-warning' }}">
                                                    <i class="bi bi-star{{ $service->is_featured ? '-fill' : '' }}"></i>
                                                </button>
                                                <button wire:click="delete({{ $service->id }})" 
                                                        class="btn btn-sm btn-danger"
                                                        wire:confirm="Are you sure you want to delete this service?">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No services found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        {{ $services->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
