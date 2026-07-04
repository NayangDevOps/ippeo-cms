@extends('layouts.frontend')

@section('title', $category->name)
@section('meta_description', $category->meta_description ?? "Browse {$category->name} products")
@section('meta_keywords', $category->meta_keywords)

@section('content')
<nav aria-label="breadcrumb" class="bg-light py-3">
    <div class="container">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('categories.index') }}">Categories</a></li>
            <li class="breadcrumb-item active">{{ $category->name }}</li>
        </ol>
    </div>
</nav>

<section class="py-5">
    <div class="container">
        <div class="row mb-4">
            <div class="col-md-8">
                <h1 class="fw-bold">{{ $category->name }}</h1>
                @if($category->description)
                <p class="text-muted">{{ $category->description }}</p>
                @endif
            </div>
            <div class="col-md-4">
                <form method="GET" class="d-flex">
                    <select name="sort" class="form-select" onchange="this.form.submit()">
                        <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest</option>
                        <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                        <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                        <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Most Popular</option>
                        <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Highest Rated</option>
                    </select>
                </form>
            </div>
        </div>

        <div class="row g-4">
            @forelse($products as $product)
            <div class="col-md-4 col-lg-3">
                <div class="product-card card h-100 shadow-sm">
                    <div class="product-image">
                        <img src="{{ $product->featured_image_url }}" alt="{{ $product->name }}" class="card-img-top" style="height: 250px; object-fit: cover;">
                        @if($product->isOnSale())
                        <span class="badge bg-danger position-absolute top-0 end-0 m-2">-{{ $product->discount_percentage }}%</span>
                        @endif
                    </div>
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <div class="mb-2">
                            @for($i = 1; $i <= 5; $i++)
                            <i class="fas fa-star{{ $i <= $product->rating ? ' text-warning' : '-o text-muted' }}"></i>
                            @endfor
                            <small class="text-muted">({{ $product->reviews_count }})</small>
                        </div>
                        <div class="mt-auto">
                            <div class="mb-2">
                                <span class="h5 text-success fw-bold">₹{{ number_format($product->current_price, 2) }}</span>
                                @if($product->isOnSale())
                                <span class="text-muted text-decoration-line-through ms-1">₹{{ number_format($product->price, 2) }}</span>
                                @endif
                            </div>
                            <a href="{{ route('products.show', $product->slug) }}" class="btn btn-success w-100">View Details</a>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="alert alert-info text-center">
                    <i class="fas fa-info-circle fa-2x mb-3"></i>
                    <h4>No Products Found</h4>
                    <p class="mb-0">This category has no products yet.</p>
                </div>
            </div>
            @endforelse
        </div>

        @if($products->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $products->links() }}
        </div>
        @endif
    </div>
</section>
@endsection
