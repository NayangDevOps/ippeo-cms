@extends('layouts.admin')

@section('title', isset($category) ? 'Edit Category' : 'Add Category')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0">{{ isset($category) ? 'Edit Category' : 'Add New Category' }}</h2>
    <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>Back
    </a>
</div>

<form action="{{ isset($category) ? route('admin.categories.update', $category) : route('admin.categories.store') }}" 
      method="POST" enctype="multipart/form-data">
    @csrf
    @if(isset($category)) @method('PUT') @endif

    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header"><h5 class="mb-0">Category Information</h5></div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name', $category->name ?? '') }}" required>
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="slug" class="form-label">Slug</label>
                        <input type="text" class="form-control" id="slug" name="slug" value="{{ old('slug', $category->slug ?? '') }}">
                        <small class="text-muted">Leave blank to auto-generate</small>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" name="description" rows="4">{{ old('description', $category->description ?? '') }}</textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="parent_id" class="form-label">Parent Category</label>
                                <select class="form-select" name="parent_id">
                                    <option value="">None (Top Level)</option>
                                    @foreach($parentCategories ?? [] as $cat)
                                        @if(!isset($category) || $cat->id != $category->id)
                                        <option value="{{ $cat->id }}" {{ old('parent_id', $category->parent_id ?? '') == $cat->id ? 'selected' : '' }}>
                                            {{ $cat->name }}
                                        </option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="order" class="form-label">Display Order</label>
                                <input type="number" class="form-control" name="order" value="{{ old('order', $category->order ?? 0) }}">
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="meta_title" class="form-label">Meta Title</label>
                        <input type="text" class="form-control" name="meta_title" value="{{ old('meta_title', $category->meta_title ?? '') }}">
                    </div>
                    
                    <div class="mb-3">
                        <label for="meta_description" class="form-label">Meta Description</label>
                        <textarea class="form-control" name="meta_description" rows="2">{{ old('meta_description', $category->meta_description ?? '') }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header"><h5 class="mb-0">Category Image</h5></div>
                <div class="card-body text-center">
                    @if(isset($category) && $category->image)
                        <img src="{{ $category->image_url }}" class="img-thumbnail mb-2 d-block mx-auto" style="max-height: 150px;">
                    @endif
                    <input type="file" class="form-control" name="image" accept="image/*">
                    <small class="text-muted">Recommended: 400x400px</small>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" name="is_active" value="1" 
                               {{ old('is_active', $category->is_active ?? true) ? 'checked' : '' }}>
                        <label class="form-check-label">Active</label>
                    </div>

                    <button type="submit" class="btn btn-success w-100">
                        <i class="fas fa-save me-2"></i>{{ isset($category) ? 'Update' : 'Create' }} Category
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script>
document.getElementById('name').addEventListener('input', function() {
    const slug = this.value.toLowerCase().replace(/[^\w\s-]/g, '').replace(/\s+/g, '-');
    document.getElementById('slug').value = slug;
});
</script>
@endpush
