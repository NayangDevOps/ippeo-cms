@extends('layouts.admin')

@section('title', 'Edit Banner')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0">Edit Banner</h2>
    <a href="{{ route('admin.banners.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>Back
    </a>
</div>

<form action="{{ route('admin.banners.update', $banner) }}" 
      method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    
    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header"><h5 class="mb-0">Banner Information</h5></div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" 
                               id="title" name="title" value="{{ old('title', $banner->title) }}" required>
                        @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="subtitle" class="form-label">Subtitle</label>
                        <input type="text" class="form-control" name="subtitle" value="{{ old('subtitle', $banner->subtitle) }}">
                    </div>
                    
                    <div class="mb-3">
                        <label for="link" class="form-label">Link URL</label>
                        <input type="url" class="form-control" name="link" value="{{ old('link', $banner->link) }}">
                    </div>
                    
                    <div class="mb-3">
                        <label for="button_text" class="form-label">Button Text</label>
                        <input type="text" class="form-control" name="button_text" value="{{ old('button_text', $banner->button_text) }}">
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="start_date" class="form-label">Start Date</label>
                                <input type="date" class="form-control" name="start_date" 
                                       value="{{ old('start_date', $banner->start_date ? $banner->start_date->format('Y-m-d') : '') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="end_date" class="form-label">End Date</label>
                                <input type="date" class="form-control" name="end_date" 
                                       value="{{ old('end_date', $banner->end_date ? $banner->end_date->format('Y-m-d') : '') }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header"><h5 class="mb-0">Banner Image</h5></div>
                <div class="card-body">
                    @if($banner->image)
                        <div class="mb-2">
                            <label class="form-label">Current Image:</label>
                            <img src="{{ $banner->image_url }}" class="img-thumbnail d-block" style="max-height: 200px;">
                        </div>
                    @endif
                    <input type="file" class="form-control @error('image') is-invalid @enderror" 
                           name="image" accept="image/*">
                    <small class="text-muted">Upload new image to replace. Recommended: 1600x500px</small>
                    @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>
            
            <div class="card mb-4">
                <div class="card-header"><h5 class="mb-0">Settings</h5></div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="position" class="form-label">Position <span class="text-danger">*</span></label>
                        <select class="form-select" name="position" required>
                            <option value="home_slider" {{ old('position', $banner->position) == 'home_slider' ? 'selected' : '' }}>Home Slider</option>
                            <option value="home_banner" {{ old('position', $banner->position) == 'home_banner' ? 'selected' : '' }}>Home Banner</option>
                            <option value="sidebar" {{ old('position', $banner->position) == 'sidebar' ? 'selected' : '' }}>Sidebar</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="order" class="form-label">Display Order</label>
                        <input type="number" class="form-control" name="order" value="{{ old('order', $banner->order) }}">
                    </div>
                    
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" name="is_active" value="1" 
                               {{ old('is_active', $banner->is_active) ? 'checked' : '' }}>
                        <label class="form-check-label">Active</label>
                    </div>
                    
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-save me-2"></i>Update Banner
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
