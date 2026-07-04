@extends('layouts.frontend')

@section('title', $blog->title)
@section('meta_description', $blog->meta_description ?? strip_tags($blog->excerpt))
@section('meta_keywords', $blog->meta_keywords)

@section('content')
<nav aria-label="breadcrumb" class="bg-light py-3">
    <div class="container">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('blog.index') }}">Blog</a></li>
            <li class="breadcrumb-item active">{{ $blog->title }}</li>
        </ol>
    </div>
</nav>

<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <article>
                    @if($blog->featured_image)
                    <img src="{{ Storage::url($blog->featured_image) }}" alt="{{ $blog->title }}" class="img-fluid rounded shadow mb-4 w-100" style="max-height: 500px; object-fit: cover;">
                    @endif

                    <div class="mb-4">
                        <h1 class="fw-bold">{{ $blog->title }}</h1>
                        <div class="text-muted">
                            <i class="far fa-user me-1"></i>{{ $blog->author->name }}
                            <span class="ms-3"><i class="far fa-calendar me-1"></i>{{ $blog->published_at->format('M d, Y') }}</span>
                            <span class="ms-3"><i class="far fa-eye me-1"></i>{{ $blog->views }} views</span>
                        </div>
                    </div>

                    @if($blog->excerpt)
                    <div class="lead mb-4 fst-italic">{{ $blog->excerpt }}</div>
                    @endif

                    <div class="blog-content">
                        {!! nl2br(e($blog->content)) !!}
                    </div>
                </article>

                <div class="mt-5">
                    <a href="{{ route('blog.index') }}" class="btn btn-outline-success">
                        <i class="fas fa-arrow-left me-2"></i>Back to Blog
                    </a>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Recent Posts</h5>
                    </div>
                    <div class="card-body">
                        @forelse($recentBlogs as $recent)
                        <div class="mb-3 pb-3 border-bottom">
                            <a href="{{ route('blog.show', $recent->slug) }}" class="text-decoration-none">
                                <h6 class="mb-1 text-dark">{{ $recent->title }}</h6>
                            </a>
                            <small class="text-muted">{{ $recent->published_at->format('M d, Y') }}</small>
                        </div>
                        @empty
                        <p class="text-muted mb-0">No recent posts.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
