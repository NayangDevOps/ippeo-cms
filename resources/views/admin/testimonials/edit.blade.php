@extends('layouts.admin')

@section('title', 'Edit Testimonial')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0">Edit Testimonial</h2>
    <a href="{{ route('admin.testimonials.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>Back
    </a>
</div>

<form action="{{ route('admin.testimonials.update', $testimonial) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               name="name" value="{{ old('name', $testimonial->name) }}" required>
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Position <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="position" value="{{ old('position', $testimonial->position) }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Company</label>
                                <input type="text" class="form-control" name="company" value="{{ old('company', $testimonial->company) }}">
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Testimonial <span class="text-danger">*</span></label>
                        <textarea class="form-control" name="testimonial" rows="5" required>{{ old('testimonial', $testimonial->testimonial) }}</textarea>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Rating <span class="text-danger">*</span></label>
                                <select class="form-select" name="rating" required>
                                    @for($i = 5; $i >= 1; $i--)
                                    <option value="{{ $i }}" {{ old('rating', $testimonial->rating) == $i ? 'selected' : '' }}>{{ $i }} Star{{ $i > 1 ? 's' : '' }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Display Order</label>
                                <input type="number" class="form-control" name="order" value="{{ old('order', $testimonial->order) }}">
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
                    @if($testimonial->image)
                        <img src="{{ asset('storage/' . $testimonial->image) }}" class="img-thumbnail mb-2 rounded-circle d-block mx-auto" style="width: 150px; height: 150px; object-fit: cover;">
                    @endif
                    <input type="file" class="form-control" name="image" accept="image/*">
                    <small class="text-muted">Upload new to replace</small>
                </div>
            </div>
            
            <div class="card">
                <div class="card-body">
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" name="is_active" value="1" {{ old('is_active', $testimonial->is_active) ? 'checked' : '' }}>
                        <label class="form-check-label">Active</label>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-save me-2"></i>Update Testimonial
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
