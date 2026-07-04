@extends('layouts.frontend')

@section('title', 'Blog - Cosmetic CMS')

@section('content')
<!-- Breadcrumb -->
<nav aria-label="breadcrumb" class="bg-light py-3">
    <div class="container">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active">Blog</li>
        </ol>
    </div>
</nav>

<!-- Blog Section -->
<section class="py-5">
    <div class="container">
        <h1 class="mb-4">Latest Blog Posts</h1>

        <div class="row">
            @forelse($blogs as $blog)
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm">
                    @if($blog->featured_image)
                    <img src="{{ Storage::url($blog->featured_image) }}" class="card-img-top" alt="{{ $blog->title }}" style="height: 200px; object-fit: cover;">
                    @else
                    <div class="bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                        <i class="fas fa-newspaper fa-4x text-muted"></i>
                    </div>
                    @endif
                    
                    <div class="card-body">
                        <div class="mb-2">
                            <span class="badge bg-success">Blog</span>
                            <small class="text-muted ms-2">
                                <i class="far fa-calendar"></i> {{ $blog->published_at ? $blog->published_at->format('M d, Y') : $blog->created_at->format('M d, Y') }}
                            </small>
                        </div>
                        <h5 class="card-title">{{ $blog->title }}</h5>
                        <p class="card-text text-muted">{{ Str::limit(strip_tags($blog->excerpt ?: $blog->content), 120) }}</p>
                        <a href="{{ route('blog.show', $blog->slug) }}" class="btn btn-outline-success btn-sm">Read More <i class="fas fa-arrow-right ms-1"></i></a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="alert alert-info text-center">
                    <i class="fas fa-info-circle fa-2x mb-3"></i>
                    <h4>No Blog Posts Yet</h4>
                    <p class="mb-0">Check back soon for our latest beauty tips and product updates!</p>
                </div>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($blogs->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $blogs->links() }}
        </div>
        @endif
    </div>
</section>
@endsection
