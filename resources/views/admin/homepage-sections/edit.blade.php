@extends('layouts.admin')

@section('title', 'Edit Homepage Section')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0">Edit Homepage Section</h2>
    <a href="{{ route('admin.homepage-sections.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>Back
    </a>
</div>

<form action="{{ route('admin.homepage-sections.update', $homepageSection) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header"><h5 class="mb-0">Section Content</h5></div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="section_name" class="form-label">Section Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('section_name') is-invalid @enderror" 
                               name="section_name" value="{{ old('section_name', $homepageSection->section_name) }}" required>
                        @error('section_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" name="title" value="{{ old('title', $homepageSection->title) }}">
                    </div>

                    <div class="mb-3">
                        <label for="subtitle" class="form-label">Subtitle</label>
                        <textarea class="form-control" name="subtitle" rows="2">{{ old('subtitle', $homepageSection->subtitle) }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="content" class="form-label">Content</label>
                        <textarea class="form-control" name="content" rows="4">{{ old('content', $homepageSection->content) }}</textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="button_text" class="form-label">Button Text</label>
                                <input type="text" class="form-control" name="button_text" value="{{ old('button_text', $homepageSection->button_text) }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="button_link" class="form-label">Button Link</label>
                                <input type="text" class="form-control" name="button_link" value="{{ old('button_link', $homepageSection->button_link) }}">
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="order" class="form-label">Display Order</label>
                        <input type="number" class="form-control" name="order" value="{{ old('order', $homepageSection->order ?? 0) }}">
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header"><h5 class="mb-0">Section Image</h5></div>
                <div class="card-body">
                    @if($homepageSection->image)
                        <img src="{{ asset('storage/' . $homepageSection->image) }}" class="img-thumbnail mb-2 d-block" style="max-height: 150px;">
                    @endif
                    <input type="file" class="form-control @error('image') is-invalid @enderror" name="image" accept="image/*">
                    <small class="text-muted">Recommended: 1200x600px. Upload new image to replace.</small>
                    @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" name="is_active" value="1" 
                               {{ old('is_active', $homepageSection->is_active) ? 'checked' : '' }}>
                        <label class="form-check-label">Active</label>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-save me-2"></i>Update Section
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
