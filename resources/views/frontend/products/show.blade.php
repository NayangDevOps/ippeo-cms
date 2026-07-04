@extends('layouts.frontend')

@section('title', $product->name)
@section('meta_description', $product->meta_description ?? $product->short_description)
@section('meta_keywords', $product->meta_keywords)

@section('content')
<!-- Product Details -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <!-- Product Images -->
            <div class="col-md-6">
                <div class="product-images mb-4">
                    <div class="main-image mb-3">
                        <img src="{{ $product->featured_image_url }}" alt="{{ $product->name }}" class="img-fluid rounded shadow" id="mainImage">
                    </div>
                    @if($product->images->count() > 0)
                    <div class="row g-2">
                        @foreach($product->images as $image)
                        <div class="col-3">
                            <img src="{{ $image->image_url }}" alt="{{ $product->name }}" class="img-fluid rounded cursor-pointer thumbnail-image" onclick="changeMainImage('{{ $image->image_url }}')">
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>

            <!-- Product Info -->
            <div class="col-md-6">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Products</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('categories.show', $product->category->slug) }}">{{ $product->category->name }}</a></li>
                        <li class="breadcrumb-item active">{{ $product->name }}</li>
                    </ol>
                </nav>

                <h1 class="h2 fw-bold mb-3">{{ $product->name }}</h1>
                
                <div class="d-flex align-items-center mb-3">
                    <div class="product-rating me-3">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="fas fa-star{{ $i <= $product->rating ? '' : '-o' }}"></i>
                        @endfor
                        <span class="ms-2">({{ $product->reviews_count }} reviews)</span>
                    </div>
                    @if($product->is_bestseller)
                    <span class="badge bg-warning">Bestseller</span>
                    @endif
                </div>

                <div class="mb-3">
                    <span class="h3 text-green fw-bold">₹{{ number_format($product->current_price, 2) }}</span>
                    @if($product->isOnSale())
                    <span class="h5 text-muted text-decoration-line-through ms-2">₹{{ number_format($product->price, 2) }}</span>
                    <span class="badge bg-danger ms-2">Save {{ $product->discount_percentage }}%</span>
                    @endif
                </div>

                <div class="mb-4">
                    <p class="text-muted"><strong>SKU:</strong> {{ $product->sku }}</p>
                    <p class="text-muted"><strong>Availability:</strong> 
                        @if($product->isInStock())
                        <span class="text-success">In Stock ({{ $product->stock }} available)</span>
                        @else
                        <span class="text-danger">Out of Stock</span>
                        @endif
                    </p>
                </div>

                @if($product->short_description)
                <p class="lead">{{ $product->short_description }}</p>
                @endif

                @if($product->tags->count() > 0)
                <div class="mb-4">
                    <strong>Tags:</strong>
                    @foreach($product->tags as $tag)
                    <span class="badge bg-green-light me-1">{{ $tag->name }}</span>
                    @endforeach
                </div>
                @endif

                <hr>

                <div class="d-grid gap-2">
                    <button class="btn btn-green btn-lg" disabled>
                        <i class="fas fa-shopping-cart me-2"></i>Add to Cart (Coming Soon)
                    </button>
                </div>

                <!-- Share Options -->
                <div class="mt-4">
                    <strong>Share:</strong>
                    <a href="#" class="btn btn-sm btn-outline-secondary ms-2"><i class="fab fa-facebook"></i></a>
                    <a href="#" class="btn btn-sm btn-outline-secondary"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="btn btn-sm btn-outline-secondary"><i class="fab fa-pinterest"></i></a>
                    <a href="#" class="btn btn-sm btn-outline-secondary"><i class="fab fa-whatsapp"></i></a>
                </div>
            </div>
        </div>

        <!-- Product Tabs -->
        <div class="row mt-5">
            <div class="col-12">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#description">Description</a>
                    </li>
                    @if($product->ingredients)
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#ingredients">Ingredients</a>
                    </li>
                    @endif
                    @if($product->benefits)
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#benefits">Benefits</a>
                    </li>
                    @endif
                    @if($product->usage_guide)
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#usage">How to Use</a>
                    </li>
                    @endif
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#reviews">Reviews ({{ $product->reviews_count }})</a>
                    </li>
                </ul>

                <div class="tab-content p-4 bg-light">
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
                        <!-- Reviews List -->
                        @forelse($product->approvedReviews as $review)
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h6 class="mb-1">{{ $review->name }}</h6>
                                        <div class="text-warning">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="fas fa-star{{ $i <= $review->rating ? '' : '-o' }}"></i>
                                            @endfor
                                        </div>
                                    </div>
                                    <small class="text-muted">{{ $review->created_at->format('M d, Y') }}</small>
                                </div>
                                <p class="mt-2 mb-0">{{ $review->comment }}</p>
                            </div>
                        </div>
                        @empty
                        <p class="text-muted">No reviews yet. Be the first to review this product!</p>
                        @endforelse

                        <!-- Review Form -->
                        <div class="card mt-4">
                            <div class="card-body">
                                <h5 class="card-title">Write a Review</h5>
                                <form action="{{ route('products.review', $product) }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label">Name *</label>
                                        <input type="text" name="name" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Email *</label>
                                        <input type="email" name="email" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Rating *</label>
                                        <select name="rating" class="form-select" required>
                                            <option value="">Select rating</option>
                                            <option value="5">5 Stars - Excellent</option>
                                            <option value="4">4 Stars - Good</option>
                                            <option value="3">3 Stars - Average</option>
                                            <option value="2">2 Stars - Poor</option>
                                            <option value="1">1 Star - Terrible</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Review *</label>
                                        <textarea name="comment" class="form-control" rows="4" required></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-green">Submit Review</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Products -->
        @if($relatedProducts->count() > 0)
        <div class="row mt-5">
            <div class="col-12">
                <h3 class="section-title">Related Products</h3>
                <div class="row g-4">
                    @foreach($relatedProducts as $relatedProduct)
                    <div class="col-md-3">
                        <div class="product-card">
                            <div class="product-image">
                                <img src="{{ $relatedProduct->featured_image_url }}" alt="{{ $relatedProduct->name }}">
                            </div>
                            <div class="product-body">
                                <h5 class="product-title">{{ $relatedProduct->name }}</h5>
                                <div class="product-price">₹{{ number_format($relatedProduct->current_price, 2) }}</div>
                                <a href="{{ route('products.show', $relatedProduct->slug) }}" class="btn btn-green w-100 mt-2">View Details</a>
                            </div>
                        </div>
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
        this.classList.add('border', 'border-success', 'border-3');
    });
});
</script>
@endpush
