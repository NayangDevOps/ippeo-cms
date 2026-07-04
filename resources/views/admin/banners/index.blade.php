@extends('layouts.admin')

@section('title', 'Banners Management')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0">Banners Management</h2>
    <div class="d-flex gap-2">
        <form method="GET" action="{{ route('admin.banners.index') }}" class="d-flex align-items-center gap-2">
            <select name="position" class="form-select form-select-sm" style="width:auto" onchange="this.form.submit()">
                <option value="">All Positions</option>
                <option value="home_slider" {{ request('position') == 'home_slider' ? 'selected' : '' }}>Home Slider</option>
                <option value="home_banner" {{ request('position') == 'home_banner' ? 'selected' : '' }}>Home Banner</option>
                <option value="sidebar" {{ request('position') == 'sidebar' ? 'selected' : '' }}>Sidebar</option>
            </select>
            <select name="status" class="form-select form-select-sm" style="width:auto" onchange="this.form.submit()">
                <option value="">All Status</option>
                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
            @if(request('position') || request('status'))
                <a href="{{ route('admin.banners.index') }}" class="btn btn-sm btn-outline-secondary">Clear</a>
            @endif
        </form>
        <a href="{{ route('admin.banners.create') }}" class="btn btn-success">
            <i class="fas fa-plus me-2"></i>Add New Banner
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th style="width: 100px;">Image</th>
                        <th>Title</th>
                        <th>Position</th>
                        <th>Order</th>
                        <th>Active Period</th>
                        <th>Status</th>
                        <th style="width: 200px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($banners as $banner)
                    <tr>
                        <td>
                            <img src="{{ $banner->image_url }}" alt="{{ $banner->title }}" 
                                 class="img-thumbnail" style="width: 80px; height: 50px; object-fit: cover;">
                        </td>
                        <td>
                            <strong>{{ $banner->title }}</strong>
                            @if($banner->subtitle)
                                <br><small class="text-muted">{{ Str::limit($banner->subtitle, 40) }}</small>
                            @endif
                        </td>
                        <td><span class="badge bg-info">{{ str_replace('_', ' ', ucfirst($banner->position)) }}</span></td>
                        <td>{{ $banner->order }}</td>
                        <td>
                            @if($banner->start_date)
                                <small>From: {{ $banner->start_date->format('M d, Y') }}</small><br>
                            @endif
                            @if($banner->end_date)
                                <small>To: {{ $banner->end_date->format('M d, Y') }}</small>
                            @endif
                            @if(!$banner->start_date && !$banner->end_date)
                                <span class="text-muted">Always</span>
                            @endif
                        </td>
                        <td>
                            <form action="{{ route('admin.banners.toggle-status', $banner) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-{{ $banner->is_active ? 'success' : 'secondary' }}">
                                    {{ $banner->is_active ? 'Active' : 'Inactive' }}
                                </button>
                            </form>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.banners.edit', $banner) }}" class="btn btn-primary" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.banners.destroy', $banner) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Delete this banner?');">
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
                        <td colspan="7" class="text-center py-4">
                            <p class="text-muted mb-0">No banners found.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
