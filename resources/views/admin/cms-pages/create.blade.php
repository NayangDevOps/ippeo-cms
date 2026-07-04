@extends('layouts.admin')

@section('title', 'Add New CMS Page')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0">Add New CMS Page</h2>
    <a href="{{ route('admin.cms-pages.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>Back
    </a>
</div>

<form action="{{ route('admin.cms-pages.store') }}" method="POST">
    @csrf

    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header"><h5 class="mb-0">Page Content</h5></div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" 
                               id="title" name="title" value="{{ old('title') }}" required>
                        @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="slug" class="form-label">Slug</label>
                        <input type="text" class="form-control" id="slug" name="slug" value="{{ old('slug') }}">
                        <small class="text-muted">Leave blank to auto-generate</small>
                    </div>
                    
                    <div class="mb-3">
                        <label for="content" class="form-label">Content <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('content') is-invalid @enderror" 
                                  name="content" rows="12" required>{{ old('content') }}</textarea>
                        @error('content') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>
            
            <div class="card mb-4">
                <div class="card-header"><h5 class="mb-0">SEO Settings</h5></div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="meta_title" class="form-label">Meta Title</label>
                        <input type="text" class="form-control" name="meta_title" value="{{ old('meta_title') }}">
                    </div>
                    
                    <div class="mb-3">
                        <label for="meta_description" class="form-label">Meta Description</label>
                        <textarea class="form-control" name="meta_description" rows="3">{{ old('meta_description') }}</textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label for="meta_keywords" class="form-label">Meta Keywords</label>
                        <input type="text" class="form-control" name="meta_keywords" value="{{ old('meta_keywords') }}">
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header"><h5 class="mb-0">Settings</h5></div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="template" class="form-label">Template <span class="text-danger">*</span></label>
                        <select class="form-select @error('template') is-invalid @enderror" name="template" required>
                            <option value="default" {{ old('template') == 'default' ? 'selected' : '' }}>Default</option>
                            <option value="full-width" {{ old('template') == 'full-width' ? 'selected' : '' }}>Full Width</option>
                            <option value="sidebar" {{ old('template') == 'sidebar' ? 'selected' : '' }}>With Sidebar</option>
                        </select>
                        @error('template') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" name="is_active" value="1" 
                               {{ old('is_active', true) ? 'checked' : '' }}>
                        <label class="form-check-label">Active</label>
                    </div>
                    
                    <button type="submit" class="btn btn-success w-100">
                        <i class="fas fa-save me-2"></i>Create Page
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script>
document.getElementById('title').addEventListener('input', function() {
    const slug = this.value.toLowerCase().replace(/[^\w\s-]/g, '').replace(/\s+/g, '-');
    document.getElementById('slug').value = slug;
});
</script>
@endpush
