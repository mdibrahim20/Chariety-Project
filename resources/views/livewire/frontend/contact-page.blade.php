@if ($hero && $hero->is_active)
    <!-- Breadcrumb Area Start -->
    <section class="breadcrumb-area" 
             @if ($hero->background_image)
                 style="background-image: url('{{ asset('storage/' . $hero->background_image) }}');"
             @endif>
        @if ($hero->overlay_enabled)
            <div class="breadcrumb-overlay" style="opacity: {{ $hero->overlay_opacity / 100 }};"></div>
        @endif
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="breadcrumb-box text-center">
                        <h2 class="breadcrumb-title">{{ $hero->page_title }}</h2>
                        <ul class="breadcrumb-list">
                            <li><a href="/">{{ $hero->breadcrumb_home_label }}</a></li>
                            <li class="active">{{ $hero->breadcrumb_current_label }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Area End -->
@endif

<!-- Contact Area Start -->
<section class="contact-area pt-120 pb-120">
    <div class="container">
        @if ($settings)
            <!-- Contact Form and Map Row -->
            <div class="row mb-60">
                <!-- Google Map Column -->
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <div class="contact-map">
                        @if ($settings->google_map_embed)
                            {!! $settings->google_map_embed !!}
                        @else
                            <div class="map-placeholder bg-light d-flex align-items-center justify-content-center" style="height: 500px;">
                                <p class="text-muted">Map will appear here</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Contact Form Column -->
                <div class="col-lg-6">
                    <div class="contact-form-wrapper">
                        @if ($settings->badge_label)
                            <span class="contact-badge">{{ $settings->badge_label }}</span>
                        @endif
                        
                        <h2 class="contact-title mb-3">{{ $settings->main_heading }}</h2>
                        
                        @if ($settings->description)
                            <p class="contact-description mb-4">{{ $settings->description }}</p>
                        @endif

                        @if (session()->has('success'))
                            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if (session()->has('error'))
                            <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <form wire:submit.prevent="submit">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <input type="text" class="form-control @error('first_name') is-invalid @enderror" 
                                           placeholder="First Name *" wire:model="first_name">
                                    @error('first_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <input type="text" class="form-control @error('last_name') is-invalid @enderror" 
                                           placeholder="Last Name *" wire:model="last_name">
                                    @error('last_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                           placeholder="Email Address *" wire:model="email">
                                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <input type="number" step="0.01" class="form-control @error('amount') is-invalid @enderror" 
                                           placeholder="Amount (Optional)" wire:model="amount">
                                    @error('amount') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            @if ($settings->subject_options)
                                <div class="mb-3">
                                    <select class="form-select @error('subject') is-invalid @enderror" wire:model="subject">
                                        <option value="">Select Subject</option>
                                        @foreach ($settings->subject_options_array as $option)
                                            <option value="{{ $option }}">{{ $option }}</option>
                                        @endforeach
                                    </select>
                                    @error('subject') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            @endif

                            <div class="mb-3">
                                <textarea class="form-control @error('message') is-invalid @enderror" 
                                          rows="5" placeholder="Your Message *" wire:model="message"></textarea>
                                @error('message') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <button type="submit" class="btn btn-primary btn-contact">
                                {{ $settings->submit_button_text }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Info Cards Row -->
            <div class="row">
                @if ($settings->card_phone_enabled)
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="contact-info-card text-center">
                            <div class="contact-icon mb-3">
                                <i class="fas fa-phone-alt"></i>
                            </div>
                            <h4 class="card-title">{{ $settings->card_phone_title }}</h4>
                            @if ($settings->card_phone_subtitle)
                                <p class="card-subtitle">{{ $settings->card_phone_subtitle }}</p>
                            @endif
                            @if ($settings->card_phone_1)
                                <p class="card-info"><a href="tel:{{ $settings->card_phone_1 }}">{{ $settings->card_phone_1 }}</a></p>
                            @endif
                            @if ($settings->card_phone_2)
                                <p class="card-info"><a href="tel:{{ $settings->card_phone_2 }}">{{ $settings->card_phone_2 }}</a></p>
                            @endif
                        </div>
                    </div>
                @endif

                @if ($settings->card_email_enabled)
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="contact-info-card text-center">
                            <div class="contact-icon mb-3">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <h4 class="card-title">{{ $settings->card_email_title }}</h4>
                            @if ($settings->card_email_subtitle)
                                <p class="card-subtitle">{{ $settings->card_email_subtitle }}</p>
                            @endif
                            @if ($settings->card_email_1)
                                <p class="card-info"><a href="mailto:{{ $settings->card_email_1 }}">{{ $settings->card_email_1 }}</a></p>
                            @endif
                            @if ($settings->card_email_2)
                                <p class="card-info"><a href="mailto:{{ $settings->card_email_2 }}">{{ $settings->card_email_2 }}</a></p>
                            @endif
                        </div>
                    </div>
                @endif

                @if ($settings->card_location_enabled)
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="contact-info-card text-center">
                            <div class="contact-icon mb-3">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <h4 class="card-title">{{ $settings->card_location_title }}</h4>
                            @if ($settings->card_location_subtitle)
                                <p class="card-subtitle">{{ $settings->card_location_subtitle }}</p>
                            @endif
                            @if ($settings->card_location_address)
                                <p class="card-info">{{ $settings->card_location_address }}</p>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        @endif
    </div>
</section>
<!-- Contact Area End -->

<style>
.contact-area {
    background: #f8f9fa;
}

.contact-map iframe {
    width: 100%;
    height: 500px;
    border: none;
    border-radius: 10px;
}

.contact-form-wrapper {
    background: white;
    padding: 40px;
    border-radius: 10px;
    box-shadow: 0 0 30px rgba(0,0,0,0.1);
}

.contact-badge {
    display: inline-block;
    background: #ff5e14;
    color: white;
    padding: 5px 20px;
    border-radius: 20px;
    font-size: 14px;
    font-weight: 600;
    margin-bottom: 15px;
}

.contact-title {
    font-size: 32px;
    font-weight: 700;
    color: #333;
    margin-bottom: 15px;
}

.contact-description {
    color: #666;
    line-height: 1.8;
}

.contact-form-wrapper .form-control,
.contact-form-wrapper .form-select {
    padding: 12px 20px;
    border: 1px solid #e0e0e0;
    border-radius: 5px;
    font-size: 14px;
}

.contact-form-wrapper .form-control:focus,
.contact-form-wrapper .form-select:focus {
    border-color: #ff5e14;
    box-shadow: 0 0 0 0.2rem rgba(255, 94, 20, 0.15);
}

.btn-contact {
    background: #ff5e14;
    color: white;
    padding: 15px 40px;
    border: none;
    border-radius: 5px;
    font-weight: 600;
    font-size: 16px;
    transition: all 0.3s ease;
}

.btn-contact:hover {
    background: #e54d0a;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(255, 94, 20, 0.3);
}

.contact-info-card {
    background: white;
    padding: 40px 30px;
    border-radius: 10px;
    box-shadow: 0 0 30px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
}

.contact-info-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 40px rgba(0,0,0,0.15);
}

.contact-icon {
    width: 70px;
    height: 70px;
    margin: 0 auto;
    background: linear-gradient(135deg, #ff5e14, #e54d0a);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.contact-icon i {
    font-size: 30px;
    color: white;
}

.contact-info-card .card-title {
    font-size: 22px;
    font-weight: 700;
    color: #333;
    margin-bottom: 10px;
}

.contact-info-card .card-subtitle {
    font-size: 14px;
    color: #ff5e14;
    font-weight: 600;
    margin-bottom: 15px;
}

.contact-info-card .card-info {
    color: #666;
    margin-bottom: 5px;
    line-height: 1.8;
}

.contact-info-card .card-info a {
    color: #666;
    text-decoration: none;
    transition: color 0.3s ease;
}

.contact-info-card .card-info a:hover {
    color: #ff5e14;
}

.breadcrumb-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: #000;
}
</style>
