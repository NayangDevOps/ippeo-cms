@extends('layouts.frontend')

@section('title', 'Search Results - Cosmetic CMS')

@section('content')
<!-- Breadcrumb -->
<nav aria-label="breadcrumb" class="bg-light py-3">
    <div class="container">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active">Search Results</li>
        </ol>
    </div>
</nav>

<!-- Search Results -->
<section class="py-5">
    <div class="container">
        <div class="mb-4">
            <h1>Search Results for "{{ $search }}"</h1>
            <p class="text-muted">Found {{ $products->total() }} {{ Str::plural('product', $products->total()) }}</p>
        </div>

        @if($products->count() > 0)
        <div class="row">
            @foreach($products as $product)
            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                <div class="card h-100 product-card shadow-sm">
                    @if($product->featured_image)
                    <img src="{{ Storage::url($product->featured_image) }}" class="card-img-top" alt="{{ $product->name }}" style="height: 200px; object-fit: cover;">
                    @else
                    <div class="bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                        <i class="fas fa-image fa-3x text-muted"></i>
                    </div>
                    @endif

                    @if($product->is_new)
                    <span class="badge bg-success position-absolute top-0 start-0 m-2">New</span>
                    @endif
                    @if($product->sale_price)
                    <span class="badge bg-danger position-absolute top-0 end-0 m-2">Sale</span>
                    @endif

                    <div class="card-body">
                        <p class="text-muted small mb-1">{{ $product->category->name ?? 'Uncategorized' }}</p>
                        <h6 class="card-title">{{ Str::limit($product->name, 40) }}</h6>
                        
                        <div class="mb-2">
                            @if($product->rating > 0)
                            <div class="text-warning">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $product->rating)
                                    <i class="fas fa-star"></i>
                                    @else
                                    <i class="far fa-star"></i>
                                    @endif
                                @endfor
                                <small class="text-muted">({{ $product->reviews_count }})</small>
                            </div>
                            @endif
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                @if($product->sale_price)
                                <span class="text-success fw-bold">₹{{ number_format($product->sale_price, 2) }}</span>
                                <small class="text-muted text-decoration-line-through ms-1">₹{{ number_format($product->price, 2) }}</small>
                                @else
                                <span class="text-success fw-bold">₹{{ number_format($product->price, 2) }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-white border-0">
                        <a href="{{ route('products.show', $product->slug) }}" class="btn btn-outline-success btn-sm w-100">
                            View Details
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        @if($products->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $products->appends(['q' => $search])->links() }}
        </div>
        @endif
        @else
        <div class="alert alert-info text-center py-5">
            <i class="fas fa-search fa-3x mb-3"></i>
            <h4>No Products Found</h4>
            <p class="mb-3">We couldn't find any products matching "{{ $search }}"</p>
            <p class="mb-0">Try searching with different keywords or <a href="{{ route('products.index') }}">browse all products</a></p>
        </div>
        @endif
    </div>
</section>

<style>
.product-card {
    transition: transform 0.2s;
}
.product-card:hover {
    transform: translateY(-5px);
}
</style>
@endsection
