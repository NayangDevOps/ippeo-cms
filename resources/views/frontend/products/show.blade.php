@extends('layouts.frontend')

@section('title', $product->name)
@section('meta_description', $product->meta_description ?? $product->short_description)
@section('meta_keywords', $product->meta_keywords)

@section('content')
<section class="py-4 py-md-5">
    <div class="container">
        <div class="row g-4 g-lg-5">
            <div class="col-md-6">
                <div class="product-gallery">
                    <div class="main-image mb-3 position-relative">
                        <img src="{{ $product->featured_image_url }}" alt="{{ $product->name }}" class="img-fluid rounded shadow w-100" id="mainImage" style="aspect-ratio: 1 / 1; object-fit: cover;">
                    </div>
                    @if($product->images->count() > 0)
                    <div class="row g-2">
                        @foreach($product->images as $image)
                        <div class="col-4 col-sm-3">
                            <img src="{{ $image->image_url }}" alt="{{ $product->name }}" class="img-fluid rounded cursor-pointer thumbnail-image border" style="aspect-ratio: 1 / 1; object-fit: cover;" onclick="changeMainImage('{{ $image->image_url }}')">
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>

            <div class="col-md-6">
                <h1 class="product-detail-title">{{ $product->name }}</h1>

                <div class="d-flex align-items-center flex-wrap gap-2 mb-3">
                    <div class="product-rating">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="fas fa-star{{ $i <= $product->rating ? '' : '-o' }}"></i>
                        @endfor
                        <span class="ms-2 small">({{ $product->reviews_count }} reviews)</span>
                    </div>
                    @if($product->is_bestseller)
                    <span class="badge bg-warning">Bestseller</span>
                    @endif
                </div>

                <div class="mb-3">
                    <span class="product-detail-price">₹{{ number_format($product->current_price, 2) }}</span>
                    @if($product->isOnSale())
                    <span class="product-detail-price-old">₹{{ number_format($product->price, 2) }}</span>
                    <span class="badge bg-danger ms-2">Save {{ $product->discount_percentage }}%</span>
                    @endif
                </div>

                <div class="mb-4 product-meta">
                    <p><strong>SKU:</strong> {{ $product->sku }}</p>
                    <p><strong>Availability:</strong>
                        @if($product->isInStock())
                        <span class="text-success">In Stock ({{ $product->stock }} available)</span>
                        @else
                        <span class="text-danger">Out of Stock</span>
                        @endif
                    </p>
                </div>

                @if($product->short_description)
                <p class="product-detail-desc">{{ $product->short_description }}</p>
                @endif

                @if($product->tags->count() > 0)
                <div class="mb-4 d-flex flex-wrap align-items-center gap-1">
                    <strong class="me-1">Tags:</strong>
                    @foreach($product->tags as $tag)
                    <span class="badge bg-green-light">{{ $tag->name }}</span>
                    @endforeach
                </div>
                @endif

                <hr>

                <div class="d-grid gap-2">
                    <button class="btn btn-green btn-lg" disabled>
                        <i class="fas fa-shopping-cart me-2"></i>Add to Cart (Coming Soon)
                    </button>
                    @if($product->amazon_link)
                    <a href="{{ $product->amazon_link }}" target="_blank" rel="noopener" class="btn btn-dark btn-lg">
                        <i class="fab fa-amazon me-2"></i>Buy on Amazon
                    </a>
                    @endif
                </div>

                <div class="mt-4 d-flex align-items-center flex-wrap gap-2">
                    <strong>Share:</strong>
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" target="_blank" class="btn btn-sm btn-outline-secondary" rel="noopener"><i class="fab fa-facebook"></i></a>
                    <a href="https://wa.me/?text={{ urlencode($product->name . ' - ' . request()->url()) }}" target="_blank" class="btn btn-sm btn-outline-secondary" rel="noopener"><i class="fab fa-whatsapp"></i></a>
                </div>
            </div>
        </div>

        <div class="row mt-4 mt-md-5">
            <div class="col-12">
                <ul class="nav nav-tabs product-tabs flex-nowrap overflow-auto" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active small text-nowrap" data-bs-toggle="tab" href="#description">Description</a>
                    </li>
                    @if($product->ingredients)
                    <li class="nav-item">
                        <a class="nav-link small text-nowrap" data-bs-toggle="tab" href="#ingredients">Ingredients</a>
                    </li>
                    @endif
                    @if($product->benefits)
                    <li class="nav-item">
                        <a class="nav-link small text-nowrap" data-bs-toggle="tab" href="#benefits">Benefits</a>
                    </li>
                    @endif
                    @if($product->usage_guide)
                    <li class="nav-item">
                        <a class="nav-link small text-nowrap" data-bs-toggle="tab" href="#usage">How to Use</a>
                    </li>
                    @endif
                    <li class="nav-item">
                        <a class="nav-link small text-nowrap" data-bs-toggle="tab" href="#reviews">Reviews ({{ $product->reviews_count }})</a>
                    </li>
                </ul>

                <div class="tab-content p-3 p-md-4 bg-light rounded-bottom">
                    <div id="description" class="tab-pane active">
                        {!! nl2br(e($product->description)) !!}
                    </div>
                    @if($product->ingredients)
                    <div id="ingredients" class="tab-pane fade">
                        {!! nl2br(e($product->ingredients)) !!}
                    </div>
                    @endif
                    @if($product->benefits)
                    <div id="benefits" class="tab-pane fade">
                        {!! nl2br(e($product->benefits)) !!}
                    </div>
                    @endif
                    @if($product->usage_guide)
                    <div id="usage" class="tab-pane fade">
                        {!! nl2br(e($product->usage_guide)) !!}
                    </div>
                    @endif
                    <div id="reviews" class="tab-pane fade">
                        @forelse($product->approvedReviews as $review)
                        <div class="card mb-3 border-0 shadow-sm">
                            <div class="card-body">
                                <div class="d-flex justify-content-between flex-wrap gap-2">
                                    <div>
                                        <h6 class="mb-1">{{ $review->name }}</h6>
                                        <div class="text-warning small">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="fas fa-star{{ $i <= $review->rating ? '' : '-o' }}"></i>
                                            @endfor
                                        </div>
                                    </div>
                                    <small class="text-muted text-nowrap">{{ $review->created_at->format('M d, Y') }}</small>
                                </div>
                                <p class="mt-2 mb-0 small">{{ $review->comment }}</p>
                            </div>
                        </div>
                        @empty
                        <p class="text-muted small">No reviews yet. Be the first to review this product!</p>
                        @endforelse

                        <div class="card mt-4 border-0 shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">Write a Review</h5>
                                <form action="{{ route('products.review', $product) }}" method="POST">
                                    @csrf
                                    <div class="row g-3">
                                        <div class="col-sm-6">
                                            <label class="form-label small">Name *</label>
                                            <input type="text" name="name" class="form-control form-control-sm" required>
                                        </div>
                                        <div class="col-sm-6">
                                            <label class="form-label small">Email *</label>
                                            <input type="email" name="email" class="form-control form-control-sm" required>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label small">Rating *</label>
                                            <select name="rating" class="form-select form-select-sm" required>
                                                <option value="">Select rating</option>
                                                <option value="5">5 Stars - Excellent</option>
                                                <option value="4">4 Stars - Good</option>
                                                <option value="3">3 Stars - Average</option>
                                                <option value="2">2 Stars - Poor</option>
                                                <option value="1">1 Star - Terrible</option>
                                            </select>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label small">Review *</label>
                                            <textarea name="comment" class="form-control form-control-sm" rows="4" required></textarea>
                                        </div>
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-green btn-sm">Submit Review</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if($relatedProducts->count() > 0)
        <div class="row mt-5">
            <div class="col-12">
                <h3 class="section-title">Related Products</h3>
                <div class="row g-4">
                    @foreach($relatedProducts as $relatedProduct)
                    <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                        <a href="{{ route('products.show', $relatedProduct->slug) }}" class="text-decoration-none">
                            <div class="product-card">
                                <div class="product-image">
                                    <img src="{{ $relatedProduct->featured_image_url }}" alt="{{ $relatedProduct->name }}">
                                </div>
                                <div class="product-body">
                                    <div class="product-category">{{ $relatedProduct->category->name }}</div>
                                    <h5 class="product-title">{{ $relatedProduct->name }}</h5>
                                    <div class="product-price">₹{{ number_format($relatedProduct->current_price, 2) }}</div>
                                </div>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
    </div>
</section>
@endsection

@push('scripts')
<script>
function changeMainImage(imageUrl) {
    document.getElementById('mainImage').src = imageUrl;
}

document.querySelectorAll('.thumbnail-image').forEach(img => {
    img.style.cursor = 'pointer';
    img.addEventListener('click', function() {
        document.querySelectorAll('.thumbnail-image').forEach(i => i.classList.remove('border-success', 'border-3'));
        this.classList.add('border-success', 'border-3');
    });
});
</script>
@endpush