@extends('layouts.admin')

@section('title', 'Homepage Sections Management')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0">Homepage Sections Management</h2>
    <div class="d-flex gap-2">
        <form method="GET" action="{{ route('admin.homepage-sections.index') }}" class="d-flex align-items-center gap-2">
            <select name="status" class="form-select form-select-sm" style="width:auto" onchange="this.form.submit()">
                <option value="">All Status</option>
                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
            @if(request('status'))
                <a href="{{ route('admin.homepage-sections.index') }}" class="btn btn-sm btn-outline-secondary">Clear</a>
            @endif
        </form>
        <a href="{{ route('admin.homepage-sections.create') }}" class="btn btn-success">
            <i class="fas fa-plus me-2"></i>Add New Section
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
                        <th>Section Name</th>
                        <th>Title</th>
                        <th>Order</th>
                        <th>Status</th>
                        <th style="width: 200px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($homepageSections as $section)
                    <tr>
                        <td>
                            @if($section->image)
                                <img src="{{ asset('storage/' . $section->image) }}" alt="{{ $section->title }}" 
                                     class="img-thumbnail" style="width: 80px; height: 50px; object-fit: cover;">
                            @else
                                <div class="bg-light d-flex align-items-center justify-content-center" 
                                     style="width: 80px; height: 50px;">
                                    <i class="fas fa-image text-muted"></i>
                                </div>
                            @endif
                        </td>
                        <td><span class="badge bg-primary">{{ $section->section_name }}</span></td>
                        <td>
                            <strong>{{ $section->title }}</strong>
                            @if($section->subtitle)
                                <br><small class="text-muted">{{ Str::limit($section->subtitle, 50) }}</small>
                            @endif
                        </td>
                        <td>{{ $section->order }}</td>
                        <td>
                            <form action="{{ route('admin.homepage-sections.toggle-status', $section) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-{{ $section->is_active ? 'success' : 'secondary' }}">
                                    {{ $section->is_active ? 'Active' : 'Inactive' }}
                                </button>
                            </form>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.homepage-sections.edit', $section) }}" class="btn btn-primary" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.homepage-sections.destroy', $section) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Delete this section?');">
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
                        <td colspan="6" class="text-center py-4">
                            <p class="text-muted mb-0">No homepage sections found.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
