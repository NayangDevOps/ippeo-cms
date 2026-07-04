@extends('layouts.admin')

@section('title', 'FAQs Management')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0">FAQs Management</h2>
    <div class="d-flex gap-2">
        <form method="GET" action="{{ route('admin.faqs.index') }}" class="d-flex align-items-center gap-2">
            <select name="category" class="form-select form-select-sm" style="width:auto" onchange="this.form.submit()">
                <option value="">All Categories</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                @endforeach
            </select>
            <select name="status" class="form-select form-select-sm" style="width:auto" onchange="this.form.submit()">
                <option value="">All Status</option>
                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
            @if(request('category') || request('status'))
                <a href="{{ route('admin.faqs.index') }}" class="btn btn-sm btn-outline-secondary">Clear</a>
            @endif
        </form>
        <a href="{{ route('admin.faqs.create') }}" class="btn btn-success">
            <i class="fas fa-plus me-2"></i>Add New FAQ
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Question</th>
                        <th>Category</th>
                        <th>Order</th>
                        <th>Status</th>
                        <th style="width: 200px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($faqs as $faq)
                    <tr>
                        <td>
                            <strong>{{ $faq->question }}</strong>
                            <br><small class="text-muted">{{ Str::limit($faq->answer, 80) }}</small>
                        </td>
                        <td><span class="badge bg-info">{{ $faq->category }}</span></td>
                        <td>{{ $faq->order }}</td>
                        <td>
                            <form action="{{ route('admin.faqs.toggle-status', $faq) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-{{ $faq->is_active ? 'success' : 'secondary' }}">
                                    {{ $faq->is_active ? 'Active' : 'Inactive' }}
                                </button>
                            </form>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.faqs.edit', $faq) }}" class="btn btn-primary" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.faqs.destroy', $faq) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Delete this FAQ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-4">
                            <p class="text-muted mb-0">No FAQs found.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
