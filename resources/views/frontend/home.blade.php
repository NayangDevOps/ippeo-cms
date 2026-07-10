@extends('layouts.frontend')

@section('title', 'Home')

@section('content')
<!-- Hero Slider -->
<section class="hero-slider">
    <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="4000" data-bs-pause="false">
        <div class="carousel-indicators">
            @foreach($banners as $index => $banner)
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="{{ $index }}" class="{{ $index === 0 ? 'active' : '' }}"></button>
            @endforeach
        </div>
        <div class="carousel-inner">
            @forelse($banners as $index => $banner)
            <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                <div class="banner-slide" @if($banner->image_url) style="background-image: url('{{ $banner->image_url }}');" @endif>
                </div>
            </div>
            @empty
            <div class="carousel-item active">
                <div class="banner-slide" style="background: #f8f9fa;">
                </div>
            </div>
            @endforelse
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</section>

<!-- Categories Section -->
<section class="py-4 bg-light">
    <div class="container">
        <h2 class="section-title">Shop by Category</h2>
        <p class="section-subtitle">Discover our range of natural beauty products</p>
        <div class="row g-4">
            @foreach($categories as $category)
            <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                <a href="{{ route('products.index', ['category' => $category->id]) }}" class="text-decoration-none">
                    <div class="category-card">
                        <img src="{{ $category->image_url }}" alt="{{ $category->name }}">
                        <div class="category-overlay">
                            <h4>{{ $category->name }}</h4>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Featured Products -->
<section class="py-4">
    <div class="container">
        <h2 class="section-title">Featured Products</h2>
        <p class="section-subtitle">Handpicked favorites just for you</p>
        <div class="row g-4">
            @foreach($featuredProducts as $product)
            <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                <a href="{{ route('products.show', $product->slug) }}" class="text-decoration-none">
                    <div class="product-card">
                        <div class="product-image">
                            @if($product->isOnSale())
                            <span class="product-badge">Sale {{ $product->discount_percentage }}%</span>
                            @elseif($product->is_new)
                            <span class="product-badge">New</span>
                            @endif
                            <img src="{{ $product->featured_image_url }}" alt="{{ $product->name }}">
                        </div>
                        <div class="product-body">
                            <div class="product-category">{{ $product->category->name }}</div>
                            <h5 class="product-title">{{ $product->name }}</h5>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="product-price">
                                    ₹{{ number_format($product->current_price, 2) }}
                                    @if($product->isOnSale())
                                    <span class="product-price-old">₹{{ number_format($product->price, 2) }}</span>
                                    @endif
                                </div>
                                <div class="product-rating">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star{{ $i <= $product->rating ? '' : '-o' }}"></i>
                                    @endfor
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
        <div class="text-center mt-5">
            <a href="{{ route('products.index') }}" class="btn btn-green btn-lg px-5">View All Products</a>
        </div>
    </div>
</section>

<!-- About Section -->
@if($aboutSection)
<section class="py-5 bg-green-lightest">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                @if($aboutSection->image)
                <img src="{{ $aboutSection->image_url }}" alt="{{ $aboutSection->title }}" class="img-fluid rounded shadow">
                @endif
            </div>
            <div class="col-md-6">
                <h2 class="section-title text-start">{{ $aboutSection->title }}</h2>
                <p class="section-subtitle text-start">{{ $aboutSection->subtitle }}</p>
                <p>{{ $aboutSection->content }}</p>
                @if($aboutSection->button_text && $aboutSection->button_link)
                <a href="{{ $aboutSection->button_link }}" class="btn btn-green">{{ $aboutSection->button_text }}</a>
                @endif
            </div>
        </div>
    </div>
</section>
@endif

<!-- New Arrivals -->
@if($newProducts->count() > 0)
<section class="py-4">
    <div class="container">
        <h2 class="section-title">New Arrivals</h2>
        <p class="section-subtitle">Fresh products, just arrived</p>
        <div class="row g-4">
            @foreach($newProducts->take(4) as $product)
            <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                <a href="{{ route('products.show', $product->slug) }}" class="text-decoration-none">
                    <div class="product-card">
                        <div class="product-image">
                            <span class="product-badge">New</span>
                            <img src="{{ $product->featured_image_url }}" alt="{{ $product->name }}">
                        </div>
                        <div class="product-body">
                            <div class="product-category">{{ $product->category->name }}</div>
                            <h5 class="product-title">{{ $product->name }}</h5>
                            <div class="product-price">₹{{ number_format($product->current_price, 2) }}</div>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Testimonials -->
@if($testimonials->count() > 0)
<section class="py-4 bg-cream">
    <div class="container">
        <h2 class="section-title">What Our Customers Say</h2>
        <p class="section-subtitle">Real reviews from real people</p>
        <div class="row g-4">
            @foreach($testimonials as $testimonial)
            <div class="col-md-4 col-sm-6 col-12">
                <div class="testimonial-card">
                    <img src="{{ $testimonial->image_url }}" alt="{{ $testimonial->name }}" class="testimonial-avatar">
                    <p class="testimonial-text">"{{ $testimonial->testimonial }}"</p>
                    <p class="testimonial-author">{{ $testimonial->name }}</p>
                    @if($testimonial->position)
                    <p class="small text-muted">{{ $testimonial->position }}</p>
                    @endif
                    <div class="testimonial-rating">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="fas fa-star{{ $i <= $testimonial->rating ? '' : '-o' }}"></i>
                        @endfor
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

@endsection

@push('scripts')
<script>
(function() {
    var carousel = document.getElementById('heroCarousel');
    if (!carousel) return;

    var heroCarousel = new bootstrap.Carousel(carousel, {
        interval: 4000,
        ride: 'carousel',
        pause: 'hover',
        wrap: true
    });
})();
</script>
@endpush
