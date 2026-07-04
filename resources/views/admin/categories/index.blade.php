@extends('layouts.admin')

@section('title', 'Categories Management')

@section('content')
<div class="table-container">
    <div class="table-toolbar">
        <div class="toolbar-left">
            <form method="GET" action="{{ route('admin.categories.index') }}" class="d-flex align-items-center gap-2">
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" name="search" placeholder="Search categories..." value="{{ request('search') }}">
                </div>
                <select name="status" class="form-select form-select-sm" style="width:auto" onchange="this.form.submit()">
                    <option value="">All Status</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
                @if(request('search') || request('status'))
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-sm btn-outline-secondary">Clear</a>
                @endif
            </form>
        </div>
        <div class="toolbar-right">
            <a href="{{ route('admin.categories.create') }}" class="btn btn-success btn-sm">
                <i class="fas fa-plus"></i> Add Category
            </a>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th style="width: 70px;">Image</th>
                    <th>Name</th>
                    <th>Parent</th>
                    <th>Products</th>
                    <th>Order</th>
                    <th>Status</th>
                    <th style="width: 160px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                <tr>
                    <td>
                        <img src="{{ $category->image_url }}" alt="{{ $category->name }}" 
                             class="img-thumbnail" style="width: 50px; height: 50px; object-fit: cover; border-radius:6px;">
                    </td>
                    <td><strong>{{ $category->name }}</strong></td>
                    <td>{{ $category->parent ? $category->parent->name : '-' }}</td>
                    <td><span class="badge bg-info">{{ $category->products->count() }}</span></td>
                    <td>{{ $category->order }}</td>
                    <td>
                        <form action="{{ route('admin.categories.toggle-status', $category) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-{{ $category->is_active ? 'success' : 'secondary' }}" style="min-width:65px">
                                {{ $category->is_active ? 'Active' : 'Inactive' }}
                            </button>
                        </form>
                    </td>
                    <td>
                        <div class="btn-group btn-group-sm">
                            <a href="{{ route('categories.show', $category->slug) }}" class="btn btn-info" target="_blank" title="View">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-primary" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button type="button" class="btn btn-danger" title="Delete"
                                onclick="confirmDelete('{{ route('admin.categories.destroy', $category) }}')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7">
                        <div class="empty-state">
                            <i class="fas fa-list"></i>
                            <h5>No Categories Found</h5>
                            <p>Create your first category to organize products.</p>
                            <a href="{{ route('admin.categories.create') }}" class="btn btn-success">Add Category</a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($categories->hasPages())
    <div class="card-footer">
        {{ $categories->links() }}
    </div>
    @endif
</div>
@endsection
