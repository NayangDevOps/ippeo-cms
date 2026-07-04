@extends('layouts.admin')

@section('title', 'Edit Blog Post')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0">Edit Blog Post</h2>
    <a href="{{ route('admin.blogs.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>Back
    </a>
</div>

<form action="{{ route('admin.blogs.update', $blog) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    
    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header"><h5 class="mb-0">Blog Content</h5></div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" 
                               id="title" name="title" value="{{ old('title', $blog->title) }}" required>
                        @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="slug" class="form-label">Slug</label>
                        <input type="text" class="form-control" id="slug" name="slug" value="{{ old('slug', $blog->slug) }}">
                    </div>
                    
                    <div class="mb-3">
                        <label for="excerpt" class="form-label">Excerpt</label>
                        <textarea class="form-control" name="excerpt" rows="3">{{ old('excerpt', $blog->excerpt) }}</textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label for="content" class="form-label">Full Content <span class="text-danger">*</span></label>
                        <textarea class="form-control" name="content" rows="12" required>{{ old('content', $blog->content) }}</textarea>
                    </div>
                </div>
            </div>
            
            <div class="card mb-4">
                <div class="card-header"><h5 class="mb-0">SEO Settings</h5></div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="meta_title" class="form-label">Meta Title</label>
                        <input type="text" class="form-control" name="meta_title" value="{{ old('meta_title', $blog->meta_title) }}">
                    </div>
                    
                    <div class="mb-3">
                        <label for="meta_description" class="form-label">Meta Description</label>
                        <textarea class="form-control" name="meta_description" rows="3">{{ old('meta_description', $blog->meta_description) }}</textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label for="meta_keywords" class="form-label">Meta Keywords</label>
                        <input type="text" class="form-control" name="meta_keywords" value="{{ old('meta_keywords', $blog->meta_keywords) }}">
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header"><h5 class="mb-0">Featured Image</h5></div>
                <div class="card-body">
                    @if($blog->featured_image)
                        <img src="{{ $blog->featured_image_url }}" class="img-thumbnail mb-2 d-block" style="max-height: 150px;">
                    @endif
                    <input type="file" class="form-control @error('featured_image') is-invalid @enderror" 
                           name="featured_image" accept="image/*">
                    <small class="text-muted">Upload new to replace</small>
                    @error('featured_image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>
            
            <div class="card mb-4">
                <div class="card-header"><h5 class="mb-0">Publishing</h5></div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="published_at" class="form-label">Publish Date</label>
                        <input type="datetime-local" class="form-control" name="published_at" 
                               value="{{ old('published_at', $blog->published_at ? $blog->published_at->format('Y-m-d\TH:i') : '') }}">
                    </div>
                    
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" name="is_published" value="1" 
                               {{ old('is_published', $blog->is_published) ? 'checked' : '' }}>
                        <label class="form-check-label">Published</label>
                    </div>
                    
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-save me-2"></i>Update Blog Post
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
