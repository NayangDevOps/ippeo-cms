@extends('layouts.frontend')

@section('title', 'Categories - Cosmetic CMS')

@section('content')
<!-- Breadcrumb -->
<nav aria-label="breadcrumb" class="bg-light py-3">
    <div class="container">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active">Categories</li>
        </ol>
    </div>
</nav>

<!-- Categories Section -->
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h1 class="display-4 mb-3">Product Categories</h1>
            <p class="lead text-muted">Browse our collection by category</p>
        </div>

        <div class="row">
            @forelse($categories as $category)
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card h-100 shadow-sm hover-shadow">
                    <div class="card-body text-center p-4">
                        <div class="mb-3">
                            @if($category->image)
                            <img src="{{ Storage::url($category->image) }}" alt="{{ $category->name }}" class="rounded-circle" style="width: 120px; height: 120px; object-fit: cover;">
                            @else
                            <div class="bg-success bg-opacity-10 rounded-circle mx-auto d-flex align-items-center justify-content-center" style="width: 120px; height: 120px;">
                                <i class="fas fa-tag fa-3x text-success"></i>
                            </div>
                            @endif
                        </div>
                        <h4 class="card-title mb-2">{{ $category->name }}</h4>
                        @if($category->description)
                        <p class="card-text text-muted mb-3">{{ Str::limit($category->description, 100) }}</p>
                        @endif
                        <p class="text-muted mb-3">
                            <i class="fas fa-box"></i> {{ $category->active_products_count }} {{ Str::plural('Product', $category->active_products_count) }}
                        </p>
                        <a href="{{ route('categories.show', $category->slug) }}" class="btn btn-outline-success">
                            Browse Products <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="alert alert-info text-center py-5">
                    <i class="fas fa-info-circle fa-3x mb-3"></i>
                    <h4>No Categories Available</h4>
                    <p class="mb-0">Categories will appear here once they are added.</p>
                </div>
            </div>
            @endforelse
        </div>
    </div>
</section>

<style>
.hover-shadow {
    transition: all 0.3s ease;
}
.hover-shadow:hover {
    transform: translateY(-5px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
}
</style>
@endsection
