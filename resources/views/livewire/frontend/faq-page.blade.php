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

<!-- FAQ Area Start -->
<section class="faq-area pt-120 pb-120">
    <div class="container">
        @if ($settings)
            <div class="row">
                <div class="col-md-12">
                    <div class="section-title text-center mb-60">
                        <h2 class="title">{{ $settings->section_heading }}</h2>
                    </div>
                </div>
            </div>
        @endif

        @if ($categories->count() > 0)
            <!-- Category Tabs -->
            <div class="row mb-50">
                <div class="col-md-12">
                    <div class="faq-tabs text-center">
                        <ul class="nav nav-pills justify-content-center" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link {{ $selectedCategory === 'all' ? 'active' : '' }}" 
                                        wire:click="selectCategory('all')" 
                                        type="button">
                                    All
                                </button>
                            </li>
                            @foreach ($categories as $category)
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link {{ $selectedCategory === $category->slug ? 'active' : '' }}" 
                                            wire:click="selectCategory('{{ $category->slug }}')" 
                                            type="button">
                                        {{ $category->name }}
                                    </button>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

            <!-- FAQ Accordion -->
            @if ($faqItems->count() > 0)
                <div class="row">
                    @php
                        $halfCount = ceil($faqItems->count() / 2);
                        $leftColumn = $faqItems->take($halfCount);
                        $rightColumn = $faqItems->skip($halfCount);
                    @endphp

                    <!-- Left Column -->
                    <div class="col-lg-6">
                        <div class="accordion faq-accordion" id="faqAccordionLeft">
                            @foreach ($leftColumn as $item)
                                <div class="accordion-item mb-3">
                                    <h2 class="accordion-header" id="heading{{ $item->id }}">
                                        <button class="accordion-button {{ $openAccordion === $item->id ? '' : 'collapsed' }}" 
                                                type="button" 
                                                wire:click="toggleAccordion({{ $item->id }})">
                                            {{ $item->question }}
                                        </button>
                                    </h2>
                                    <div class="accordion-collapse collapse {{ $openAccordion === $item->id ? 'show' : '' }}" 
                                         id="collapse{{ $item->id }}">
                                        <div class="accordion-body">
                                            {!! nl2br(e($item->answer)) !!}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="col-lg-6">
                        <div class="accordion faq-accordion" id="faqAccordionRight">
                            @foreach ($rightColumn as $item)
                                <div class="accordion-item mb-3">
                                    <h2 class="accordion-header" id="heading{{ $item->id }}">
                                        <button class="accordion-button {{ $openAccordion === $item->id ? '' : 'collapsed' }}" 
                                                type="button" 
                                                wire:click="toggleAccordion({{ $item->id }})">
                                            {{ $item->question }}
                                        </button>
                                    </h2>
                                    <div class="accordion-collapse collapse {{ $openAccordion === $item->id ? 'show' : '' }}" 
                                         id="collapse{{ $item->id }}">
                                        <div class="accordion-body">
                                            {!! nl2br(e($item->answer)) !!}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @else
                <div class="row">
                    <div class="col-md-12">
                        <div class="text-center py-5">
                            <p class="text-muted">No FAQ items available for this category.</p>
                        </div>
                    </div>
                </div>
            @endif
        @else
            <div class="row">
                <div class="col-md-12">
                    <div class="text-center py-5">
                        <p class="text-muted">No FAQ categories available at the moment.</p>
                    </div>
                </div>
            </div>
        @endif
    </div>
</section>
<!-- FAQ Area End -->

<style>
.faq-area {
    background: #f8f9fa;
}

.faq-tabs .nav-pills .nav-link {
    color: #666;
    background: white;
    border: 1px solid #e0e0e0;
    border-radius: 30px;
    padding: 10px 30px;
    margin: 0 5px 10px;
    font-weight: 500;
    transition: all 0.3s ease;
}

.faq-tabs .nav-pills .nav-link:hover,
.faq-tabs .nav-pills .nav-link.active {
    background: #ff5e14;
    color: white;
    border-color: #ff5e14;
}

.faq-accordion .accordion-item {
    border: 1px solid #e0e0e0;
    border-radius: 5px;
    background: white;
}

.faq-accordion .accordion-button {
    background: white;
    color: #333;
    font-weight: 600;
    padding: 20px 25px;
    font-size: 16px;
    border: none;
}

.faq-accordion .accordion-button:not(.collapsed) {
    background: #ff5e14;
    color: white;
    box-shadow: none;
}

.faq-accordion .accordion-button:focus {
    box-shadow: none;
    border: none;
}

.faq-accordion .accordion-button::after {
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23333'%3e%3cpath fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/%3e%3c/svg%3e");
}

.faq-accordion .accordion-button:not(.collapsed)::after {
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23fff'%3e%3cpath fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/%3e%3c/svg%3e");
}

.faq-accordion .accordion-body {
    padding: 20px 25px;
    color: #666;
    line-height: 1.8;
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
