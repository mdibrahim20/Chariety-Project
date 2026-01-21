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
                                    <li class="breadcrumb-item active text-white" aria-current="page">{{ $hero->breadcrumb_current_label ?? 'Our Volunteers' }}</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    {{-- Volunteers Grid Section --}}
    <section class="volunteers-section py-5">
        <div class="container">
            @if($volunteers->isNotEmpty())
                <div class="row g-4">
                    @foreach($volunteers as $volunteer)
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="volunteer-card text-center h-100 bg-white rounded shadow-sm p-4 position-relative">
                                {{-- Profile Photo --}}
                                <div class="volunteer-photo mb-3 mx-auto" style="width: 150px; height: 150px;">
                                    @if($volunteer->profile_photo)
                                        <img src="{{ $volunteer->profile_photo_url }}" alt="{{ $volunteer->name }}" 
                                             class="img-fluid rounded-circle" 
                                             style="width: 100%; height: 100%; object-fit: cover;">
                                    @else
                                        <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center" 
                                             style="width: 100%; height: 100%;">
                                            <i class="bi bi-person text-white" style="font-size: 64px;"></i>
                                        </div>
                                    @endif
                                </div>

                                {{-- Name --}}
                                <h5 class="volunteer-name mb-1">{{ $volunteer->name }}</h5>

                                {{-- Designation --}}
                                @if($volunteer->designation)
                                    <p class="volunteer-designation text-muted mb-3">{{ $volunteer->designation }}</p>
                                @endif

                                {{-- Social Media Icons --}}
                                @if($volunteer->has_social_links)
                                    <div class="volunteer-social mt-3 d-flex justify-content-center gap-2">
                                        @if($volunteer->sanitized_facebook_url)
                                            <a href="{{ $volunteer->sanitized_facebook_url }}" target="_blank" 
                                               class="btn btn-sm btn-outline-primary rounded-circle" 
                                               style="width: 36px; height: 36px; padding: 0; display: flex; align-items: center; justify-content: center;"
                                               rel="noopener noreferrer">
                                                <i class="bi bi-facebook"></i>
                                            </a>
                                        @endif
                                        
                                        @if($volunteer->sanitized_instagram_url)
                                            <a href="{{ $volunteer->sanitized_instagram_url }}" target="_blank" 
                                               class="btn btn-sm btn-outline-danger rounded-circle" 
                                               style="width: 36px; height: 36px; padding: 0; display: flex; align-items: center; justify-content: center;"
                                               rel="noopener noreferrer">
                                                <i class="bi bi-instagram"></i>
                                            </a>
                                        @endif
                                        
                                        @if($volunteer->sanitized_twitter_url)
                                            <a href="{{ $volunteer->sanitized_twitter_url }}" target="_blank" 
                                               class="btn btn-sm btn-outline-info rounded-circle" 
                                               style="width: 36px; height: 36px; padding: 0; display: flex; align-items: center; justify-content: center;"
                                               rel="noopener noreferrer">
                                                <i class="bi bi-twitter"></i>
                                            </a>
                                        @endif
                                        
                                        @if($volunteer->sanitized_linkedin_url)
                                            <a href="{{ $volunteer->sanitized_linkedin_url }}" target="_blank" 
                                               class="btn btn-sm btn-outline-primary rounded-circle" 
                                               style="width: 36px; height: 36px; padding: 0; display: flex; align-items: center; justify-content: center;"
                                               rel="noopener noreferrer">
                                                <i class="bi bi-linkedin"></i>
                                            </a>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="row">
                    <div class="col-12 text-center py-5">
                        <p class="text-muted">No volunteers available at the moment.</p>
                    </div>
                </div>
            @endif
        </div>
    </section>
</div>

<style>
.volunteer-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.volunteer-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.15) !important;
}

.volunteer-social a {
    transition: all 0.3s ease;
}

.volunteer-social a:hover {
    transform: scale(1.1);
}
</style>
