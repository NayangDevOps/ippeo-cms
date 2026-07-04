@extends('layouts.admin')

@section('title', 'Products Management')

@section('content')
<div class="table-container">
    <div class="table-toolbar">
        <div class="toolbar-left">
            <form method="GET" action="{{ route('admin.products.index') }}" class="d-flex align-items-center gap-2">
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" name="search" placeholder="Search products..." value="{{ request('search') }}">
                </div>
                <select name="category" class="form-select form-select-sm" style="width:auto" onchange="this.form.submit()">
                    <option value="">All Categories</option>
                    @foreach(\App\Models\Category::all() as $cat)
                        <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
                <select name="status" class="form-select form-select-sm" style="width:auto" onchange="this.form.submit()">
                    <option value="">All Status</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
                @if(request('search') || request('category') || request('status'))
                    <a href="{{ route('admin.products.index') }}" class="btn btn-sm btn-outline-secondary">Clear</a>
                @endif
            </form>
        </div>
        <div class="toolbar-right">
            <a href="{{ route('admin.products.create') }}" class="btn btn-success btn-sm">
                <i class="fas fa-plus"></i> Add Product
            </a>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th style="width:40px"><input type="checkbox" class="bulk-checkbox" id="selectAll"></th>
                    <th style="width: 70px;">Image</th>
                    <th>Name</th>
                    <th>SKU</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Status</th>
                    <th style="width: 180px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                <tr>
                    <td><input type="checkbox" class="bulk-checkbox bulk-item" value="{{ $product->id }}"></td>
                    <td>
                        <img src="{{ $product->featured_image_url }}" alt="{{ $product->name }}" 
                             class="img-thumbnail" style="width: 50px; height: 50px; object-fit: cover; border-radius:6px;">
                    </td>
                    <td>
                        <strong>{{ $product->name }}</strong>
                        @if($product->is_featured)<span class="badge bg-warning ms-1">Featured</span>@endif
                        @if($product->is_new)<span class="badge bg-info ms-1">New</span>@endif
                        @if($product->is_bestseller)<span class="badge bg-danger ms-1">Bestseller</span>@endif
                    </td>
                    <td><code>{{ $product->sku }}</code></td>
                    <td>{{ $product->category->name }}</td>
                    <td>
                        <strong>₹{{ number_format($product->current_price, 2) }}</strong>
                        @if($product->isOnSale())
                            <br><small class="text-muted text-decoration-line-through">₹{{ number_format($product->price, 2) }}</small>
                        @endif
                    </td>
                    <td>
                        <span class="badge bg-{{ $product->stock > 10 ? 'success' : ($product->stock > 0 ? 'warning' : 'danger') }}">
                            {{ $product->stock }}
                        </span>
                    </td>
                    <td>
                        <form action="{{ route('admin.products.toggle-status', $product) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-{{ $product->is_active ? 'success' : 'secondary' }}" style="min-width:65px">
                                {{ $product->is_active ? 'Active' : 'Inactive' }}
                            </button>
                        </form>
                    </td>
                    <td>
                        <div class="btn-group btn-group-sm">
                            <a href="{{ route('products.show', $product->slug) }}" class="btn btn-info" target="_blank" title="View">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-primary" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button type="button" class="btn btn-danger" title="Delete"
                                onclick="confirmDelete('{{ route('admin.products.destroy', $product) }}')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9">
                        <div class="empty-state">
                            <i class="fas fa-box"></i>
                            <h5>No Products Found</h5>
                            <p>Get started by adding your first product.</p>
                            <a href="{{ route('admin.products.create') }}" class="btn btn-success">Add Product</a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($products->hasPages())
    <div class="card-footer">
        {{ $products->links() }}
    </div>
    @endif
</div>

@push('scripts')
<script>
document.getElementById('selectAll')?.addEventListener('change', function() {
    document.querySelectorAll('.bulk-item').forEach(cb => cb.checked = this.checked);
});
</script>
@endpush
@endsection
