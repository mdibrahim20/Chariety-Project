<div>
    {{-- Hero/Breadcrumb Section --}}
    @if($hero && $hero->is_active)
        <section class="breadcrumb-area" style="background-image: url('{{ $hero->background_image_url }}'); background-size: cover; background-position: center; position: relative;">
            @if($hero->overlay_enabled)
                <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,{{ $hero->overlay_opacity / 100 }});"></div>
            @endif
            <div class="container" style="position: relative; z-index: 1;">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="breadcrumb-content text-center">
                            <h2 class="breadcrumb-title text-white">{{ $hero->page_title }}</h2>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb justify-content-center">
                                    <li class="breadcrumb-item"><a href="/" class="text-white">{{ $hero->breadcrumb_home_label ?? 'Home' }}</a></li>
                                    <li class="breadcrumb-item active text-white" aria-current="page">{{ $hero->breadcrumb_current_label ?? 'Our Service' }}</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    {{-- Services Grid Section --}}
    <section class="services-section py-5">
        <div class="container">
            @if($services->isNotEmpty())
                <div class="row g-4">
                    @foreach($services as $service)
                        <div class="col-lg-4 col-md-6">
                            <div class="service-card h-100 rounded shadow-sm p-4 {{ $service->is_featured ? 'bg-warning' : 'bg-white' }}">
                                {{-- Icon --}}
                                @if($service->icon)
                                    <div class="service-icon mb-3">
                                        @if($service->icon_url)
                                            <img src="{{ $service->icon_url }}" alt="Icon" style="height: 60px; width: 60px;">
                                        @else
                                            <i class="{{ $service->icon }}" style="font-size: 48px; color: {{ $service->is_featured ? '#000' : '#007bff' }};"></i>
                                        @endif
                                    </div>
                                @endif

                                {{-- Card Image (if exists) --}}
                                @if($service->card_image)
                                    <div class="service-image mb-3">
                                        <img src="{{ $service->card_image_url }}" alt="{{ $service->title }}" 
                                             class="img-fluid rounded" style="width: 100%; height: 200px; object-fit: cover;">
                                    </div>
                                @endif

                                {{-- Title --}}
                                <h4 class="service-title mb-3">{{ $service->title }}</h4>

                                {{-- Short Description --}}
                                @if($service->short_description)
                                    <p class="service-description mb-3">{{ $service->short_description }}</p>
                                @endif

                                {{-- Button --}}
                                @if($service->button_link)
                                    <a href="{{ $service->button_link }}" 
                                       class="btn btn-{{ $service->is_featured ? 'dark' : 'primary' }} btn-sm">
                                        {{ $service->button_text ?? 'Read More' }} 
                                        <i class="bi bi-arrow-right ms-1"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="row">
                    <div class="col-12 text-center py-5">
                        <p class="text-muted">No services available at the moment.</p>
                    </div>
                </div>
            @endif
        </div>
    </section>

    {{-- Optional: Service Details Section (if you want to add featured service highlight) --}}
    @php
        $featuredService = $services->where('is_featured', true)->first();
    @endphp
    
    @if($featuredService)
        <section class="featured-service-section py-5 bg-light">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        @if($featuredService->card_image)
                            <img src="{{ $featuredService->card_image_url }}" alt="{{ $featuredService->title }}" 
                                 class="img-fluid rounded shadow">
                        @endif
                    </div>
                    <div class="col-lg-6">
                        <div class="featured-content ps-lg-4 mt-4 mt-lg-0">
                            <span class="badge bg-warning text-dark mb-2">Featured Service</span>
                            <h2 class="mb-3">{{ $featuredService->title }}</h2>
                            <p class="lead">{{ $featuredService->short_description }}</p>
                            @if($featuredService->button_link)
                                <a href="{{ $featuredService->button_link }}" class="btn btn-primary">
                                    {{ $featuredService->button_text ?? 'Learn More' }} 
                                    <i class="bi bi-arrow-right ms-1"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif
</div>
