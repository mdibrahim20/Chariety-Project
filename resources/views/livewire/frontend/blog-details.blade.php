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
                                    <li class="breadcrumb-item active text-white" aria-current="page">{{ $hero->breadcrumb_current_label ?? 'Blog Details' }}</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    {{-- Blog Details Section --}}
    <section class="blog-details-section py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <article class="blog-details-wrapper">
                        {{-- Featured Image --}}
                        @if($post->featuredImage)
                            <div class="blog-details-thumb mb-4">
                                <img src="{{ $post->featuredImage->large_url }}" alt="{{ $post->title }}" class="img-fluid w-100 rounded">
                            </div>
                        @endif

                        {{-- Meta Info --}}
                        <div class="blog-meta mb-3 d-flex flex-wrap gap-3">
                            @if($post->author)
                                <span class="author">
                                    <i class="bi bi-person me-1"></i> {{ $post->author }}
                                </span>
                            @endif
                            @if($post->publish_date)
                                <span class="date">
                                    <i class="bi bi-calendar me-1"></i> {{ $post->publish_date->format('M d, Y') }}
                                </span>
                            @endif
                            @if($post->category)
                                <span class="category">
                                    <i class="bi bi-folder me-1"></i> {{ $post->category }}
                                </span>
                            @endif
                        </div>

                        {{-- Title --}}
                        <h1 class="blog-details-title mb-3">{{ $post->title }}</h1>

                        {{-- Tags --}}
                        @if($post->tags->isNotEmpty())
                            <div class="blog-tags mb-4">
                                @foreach($post->tags as $tag)
                                    <span class="badge bg-secondary me-1">{{ $tag->name }}</span>
                                @endforeach
                            </div>
                        @endif

                        {{-- Content --}}
                        <div class="blog-details-content">
                            {!! $post->content_html !!}
                        </div>

                        {{-- Gallery Images --}}
                        @if($post->images->count() > 1)
                            <div class="blog-gallery mt-4">
                                <h4 class="mb-3">Gallery</h4>
                                <div class="row g-3">
                                    @foreach($post->images->where('is_featured', false) as $image)
                                        <div class="col-md-4">
                                            <a href="{{ $image->large_url }}" data-lightbox="blog-gallery">
                                                <img src="{{ $image->medium_url }}" alt="Gallery Image" class="img-fluid rounded">
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        {{-- Social Share --}}
                        <div class="blog-share mt-5 pt-4 border-top">
                            <h5 class="mb-3">Share this post:</h5>
                            <div class="social-links d-flex gap-2">
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" class="btn btn-primary btn-sm">
                                    <i class="bi bi-facebook me-1"></i> Facebook
                                </a>
                                <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($post->title) }}" target="_blank" class="btn btn-info btn-sm">
                                    <i class="bi bi-twitter me-1"></i> Twitter
                                </a>
                                <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(url()->current()) }}&title={{ urlencode($post->title) }}" target="_blank" class="btn btn-primary btn-sm">
                                    <i class="bi bi-linkedin me-1"></i> LinkedIn
                                </a>
                            </div>
                        </div>
                    </article>
                </div>

                {{-- Sidebar --}}
                <div class="col-lg-4">
                    <aside class="blog-sidebar">
                        {{-- Recent Posts Widget --}}
                        @if($recentPosts->isNotEmpty())
                            <div class="widget recent-posts-widget mb-4">
                                <h4 class="widget-title mb-3">Recent Posts</h4>
                                <div class="recent-posts-list">
                                    @foreach($recentPosts as $recent)
                                        <div class="recent-post-item d-flex mb-3">
                                            @if($recent->featuredImage)
                                                <div class="recent-post-thumb me-3">
                                                    <a href="{{ route('blog.show', $recent->slug) }}">
                                                        <img src="{{ $recent->featuredImage->thumb_url }}" alt="{{ $recent->title }}" 
                                                             class="img-fluid rounded" style="width: 80px; height: 60px; object-fit: cover;">
                                                    </a>
                                                </div>
                                            @endif
                                            <div class="recent-post-content">
                                                <h6 class="mb-1">
                                                    <a href="{{ route('blog.show', $recent->slug) }}" class="text-dark">{{ $recent->title }}</a>
                                                </h6>
                                                @if($recent->publish_date)
                                                    <small class="text-muted">
                                                        <i class="bi bi-calendar me-1"></i> {{ $recent->publish_date->format('M d, Y') }}
                                                    </small>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        {{-- Popular Tags Widget --}}
                        @if($popularTags->isNotEmpty())
                            <div class="widget tags-widget mb-4">
                                <h4 class="widget-title mb-3">Popular Tags</h4>
                                <div class="tag-cloud">
                                    @foreach($popularTags as $tag)
                                        <a href="#" class="badge bg-light text-dark border me-1 mb-2 text-decoration-none">
                                            {{ $tag->name }} <span class="text-muted">({{ $tag->blog_posts_count }})</span>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        {{-- Contact CTA Widget --}}
                        <div class="widget contact-widget mb-4 bg-primary text-white p-4 rounded">
                            <h4 class="widget-title text-white mb-3">Need Help?</h4>
                            <p>Have questions or want to get involved? We'd love to hear from you!</p>
                            <a href="/contact" class="btn btn-light btn-sm mt-2">Contact Us</a>
                        </div>
                    </aside>
                </div>
            </div>
        </div>
    </section>

    {{-- More Blogs Section --}}
    @if($recentPosts->isNotEmpty())
        <section class="more-blogs-section py-5 bg-light">
            <div class="container">
                <div class="row mb-4">
                    <div class="col-lg-12 text-center">
                        <h2 class="section-title">More From Our Blog</h2>
                    </div>
                </div>
                <div class="row g-4">
                    @foreach($recentPosts->take(3) as $moreBlog)
                        <div class="col-lg-4 col-md-6">
                            <div class="blog-card h-100 bg-white rounded shadow-sm">
                                @if($moreBlog->featuredImage)
                                    <div class="blog-card-thumb">
                                        <a href="{{ route('blog.show', $moreBlog->slug) }}">
                                            <img src="{{ $moreBlog->featuredImage->medium_url }}" alt="{{ $moreBlog->title }}" 
                                                 class="img-fluid w-100 rounded-top" style="height: 200px; object-fit: cover;">
                                        </a>
                                    </div>
                                @endif
                                <div class="blog-card-content p-3">
                                    @if($moreBlog->category)
                                        <span class="badge bg-primary mb-2">{{ $moreBlog->category }}</span>
                                    @endif
                                    <h5 class="blog-card-title mb-2">
                                        <a href="{{ route('blog.show', $moreBlog->slug) }}" class="text-dark text-decoration-none">
                                            {{ $moreBlog->title }}
                                        </a>
                                    </h5>
                                    @if($moreBlog->publish_date)
                                        <small class="text-muted d-block mb-2">
                                            <i class="bi bi-calendar me-1"></i> {{ $moreBlog->publish_date->format('M d, Y') }}
                                        </small>
                                    @endif
                                    <a href="{{ route('blog.show', $moreBlog->slug) }}" class="btn btn-sm btn-outline-primary">
                                        Read More <i class="bi bi-arrow-right ms-1"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
</div>
