@extends('layouts.admin')

@section('title', 'Add Testimonial')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0">Add New Testimonial</h2>
    <a href="{{ route('admin.testimonials.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>Back
    </a>
</div>

<form action="{{ route('admin.testimonials.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               name="name" value="{{ old('name') }}" required>
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Position <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="position" value="{{ old('position') }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Company</label>
                                <input type="text" class="form-control" name="company" value="{{ old('company') }}">
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Testimonial <span class="text-danger">*</span></label>
                        <textarea class="form-control" name="testimonial" rows="5" required>{{ old('testimonial') }}</textarea>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Rating <span class="text-danger">*</span></label>
                                <select class="form-select" name="rating" required>
                                    <option value="5" {{ old('rating') == 5 ? 'selected' : '' }}>5 Stars</option>
                                    <option value="4" {{ old('rating') == 4 ? 'selected' : '' }}>4 Stars</option>
                                    <option value="3" {{ old('rating') == 3 ? 'selected' : '' }}>3 Stars</option>
                                    <option value="2" {{ old('rating') == 2 ? 'selected' : '' }}>2 Stars</option>
                                    <option value="1" {{ old('rating') == 1 ? 'selected' : '' }}>1 Star</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Display Order</label>
                                <input type="number" class="form-control" name="order" value="{{ old('order', 0) }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header"><h5 class="mb-0">Image</h5></div>
                <div class="card-body">
                    <input type="file" class="form-control" name="image" accept="image/*">
                    <small class="text-muted">Recommended: 200x200px</small>
                </div>
            </div>
            
            <div class="card">
                <div class="card-body">
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" name="is_active" value="1" checked>
                        <label class="form-check-label">Active</label>
                    </div>
                    <button type="submit" class="btn btn-success w-100">
                        <i class="fas fa-save me-2"></i>Create Testimonial
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
