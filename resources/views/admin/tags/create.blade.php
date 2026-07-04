@extends('layouts.admin')

@section('title', 'Add Tag')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0">Add New Tag</h2>
    <a href="{{ route('admin.tags.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>Back
    </a>
</div>

<form action="{{ route('admin.tags.store') }}" method="POST">
    @csrf

    <div class="card">
        <div class="card-body">
            <div class="mb-3">
                <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                       id="name" name="name" value="{{ old('name') }}" required>
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label for="slug" class="form-label">Slug</label>
                <input type="text" class="form-control" id="slug" name="slug" value="{{ old('slug') }}">
                <small class="text-muted">Leave blank to auto-generate</small>
            </div>

            <button type="submit" class="btn btn-success">
                <i class="fas fa-save me-2"></i>Create Tag
            </button>
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
