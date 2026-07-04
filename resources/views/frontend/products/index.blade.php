@extends('layouts.frontend')

@section('title', 'Products')

@section('content')
<!-- Page Header -->
<section class="py-5 bg-green-lightest">
    <div class="container">
        <h1 class="section-title mb-0">Our Products</h1>
        <p class="text-center text-muted">Natural beauty for everyone</p>
    </div>
</section>

<!-- Products Section -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <!-- Filters Sidebar -->
            <div class="col-lg-3">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <h5 class="fw-bold mb-3">Filters</h5>
                        
                        <form action="{{ route('products.index') }}" method="GET" id="filterForm">
                            <!-- Search -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Search</label>
                                <input type="text" name="search" class="form-control" placeholder="Search products..." value="{{ request('search') }}">
                            </div>

                            <!-- Category Filter -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Category</label>
                                <select name="category" class="form-select">
                                    <option value="">All Categories</option>
                                    @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Price Filter -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Price Range</label>
                                <div class="row g-2">
                                    <div class="col-6">
                                        <input type="number" name="min_price" class="form-control" placeholder="Min" value="{{ request('min_price') }}">
                                    </div>
                                    <div class="col-6">
                                        <input type="number" name="max_price" class="form-control" placeholder="Max" value="{{ request('max_price') }}">
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-green w-100">Apply Filters</button>
                            <a href="{{ route('products.index') }}" class="btn btn-outline-secondary w-100 mt-2">Clear Filters</a>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Products Grid -->
            <div class="col-lg-9">
                <!-- Sort Options -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <p class="mb-0 text-muted">Showing {{ $products->count() }} of {{ $products->total() }} products</p>
                    <form action="{{ route('products.index') }}" method="GET" class="d-flex align-items-center">
                        <input type="hidden" name="search" value="{{ request('search') }}">
                        <input type="hidden" name="category" value="{{ request('category') }}">
                        <input type="hidden" name="min_price" value="{{ request('min_price') }}">
                        <input type="hidden" name="max_price" value="{{ request('max_price') }}">
                        <label class="me-2 mb-0">Sort by:</label>
                        <select name="sort" class="form-select form-select-sm" onchange="this.form.submit()" style="width: auto;">
                            <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest</option>
                            <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                            <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                            <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Most Popular</option>
                            <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Top Rated</option>
                        </select>
                    </form>
                </div>

                <!-- Products Grid -->
                <div class="row g-4">
                    @forelse($products as $product)
                    <div class="col-md-4 col-sm-6">
                        <div class="product-card">
                            <div class="product-image">
                                @if($product->isOnSale())
                                <span class="product-badge">{{ $product->discount_percentage }}% OFF</span>
                                @elseif($product->is_new)
                                <span class="product-badge">New</span>
                                @elseif($product->is_bestseller)
                                <span class="product-badge">Bestseller</span>
                                @endif
                                <img src="{{ $product->featured_image_url }}" alt="{{ $product->name }}">
                            </div>
                            <div class="product-body">
                                <div class="product-category">{{ $product->category->name }}</div>
                                <h5 class="product-title">{{ $product->name }}</h5>
                                <div class="d-flex justify-content-between align-items-center mb-2">
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
                                        <small class="text-muted">({{ $product->reviews_count }})</small>
                                    </div>
                                </div>
                                <a href="{{ route('products.show', $product->slug) }}" class="btn btn-green w-100">View Details</a>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-12">
                        <div class="alert alert-info">No products found matching your criteria.</div>
                    </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                <div class="mt-5">
                    {{ $products->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
