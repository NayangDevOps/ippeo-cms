@extends('layouts.admin')

@section('title', 'Edit FAQ')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0">Edit FAQ</h2>
    <a href="{{ route('admin.faqs.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>Back
    </a>
</div>

<form action="{{ route('admin.faqs.update', $faq) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="card">
        <div class="card-body">
            <div class="mb-3">
                <label for="question" class="form-label">Question <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('question') is-invalid @enderror" 
                       name="question" value="{{ old('question', $faq->question) }}" required>
                @error('question') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label for="answer" class="form-label">Answer <span class="text-danger">*</span></label>
                <textarea class="form-control @error('answer') is-invalid @enderror" 
                          name="answer" rows="6" required>{{ old('answer', $faq->answer) }}</textarea>
                @error('answer') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="category" class="form-label">Category</label>
                        <input type="text" class="form-control" name="category" value="{{ old('category', $faq->category) }}">
                        <small class="text-muted">e.g., Shipping, Returns, Products</small>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="order" class="form-label">Display Order</label>
                        <input type="number" class="form-control" name="order" value="{{ old('order', $faq->order ?? 0) }}">
                    </div>
                </div>
            </div>

            <div class="form-check form-switch mb-3">
                <input class="form-check-input" type="checkbox" name="is_active" value="1" 
                       {{ old('is_active', $faq->is_active) ? 'checked' : '' }}>
                <label class="form-check-label">Active</label>
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-2"></i>Update FAQ
            </button>
        </div>
    </div>
</form>
@endsection
