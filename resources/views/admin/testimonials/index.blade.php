@extends('layouts.admin')

@section('title', 'Testimonials Management')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0">Testimonials Management</h2>
    <div class="d-flex gap-2">
        <form method="GET" action="{{ route('admin.testimonials.index') }}" class="d-flex align-items-center gap-2">
            <select name="rating" class="form-select form-select-sm" style="width:auto" onchange="this.form.submit()">
                <option value="">All Ratings</option>
                @for($i = 5; $i >= 1; $i--)
                    <option value="{{ $i }}" {{ request('rating') == $i ? 'selected' : '' }}>{{ $i }} Star{{ $i > 1 ? 's' : '' }}</option>
                @endfor
            </select>
            <select name="status" class="form-select form-select-sm" style="width:auto" onchange="this.form.submit()">
                <option value="">All Status</option>
                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
            @if(request('rating') || request('status'))
                <a href="{{ route('admin.testimonials.index') }}" class="btn btn-sm btn-outline-secondary">Clear</a>
            @endif
        </form>
        <a href="{{ route('admin.testimonials.create') }}" class="btn btn-success">
            <i class="fas fa-plus me-2"></i>Add New Testimonial
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th style="width: 80px;">Image</th>
                        <th>Name</th>
                        <th>Position</th>
                        <th>Rating</th>
                        <th>Testimonial</th>
                        <th>Order</th>
                        <th>Status</th>
                        <th style="width: 200px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($testimonials as $testimonial)
                    <tr>
                        <td>
                            @if($testimonial->image)
                                <img src="{{ asset('storage/' . $testimonial->image) }}" alt="{{ $testimonial->name }}" 
                                     class="img-thumbnail rounded-circle" style="width: 60px; height: 60px; object-fit: cover;">
                            @else
                                <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center" 
                                     style="width: 60px; height: 60px;">
                                    <i class="fas fa-user text-white"></i>
                                </div>
                            @endif
                        </td>
                        <td>
                            <strong>{{ $testimonial->name }}</strong>
                            @if($testimonial->company)
                                <br><small class="text-muted">{{ $testimonial->company }}</small>
                            @endif
                        </td>
                        <td>{{ $testimonial->position }}</td>
                        <td>
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star {{ $i <= $testimonial->rating ? 'text-warning' : 'text-muted' }}"></i>
                            @endfor
                        </td>
                        <td>{{ Str::limit($testimonial->testimonial, 60) }}</td>
                        <td>{{ $testimonial->order }}</td>
                        <td>
                            <form action="{{ route('admin.testimonials.toggle-status', $testimonial) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-{{ $testimonial->is_active ? 'success' : 'secondary' }}">
                                    {{ $testimonial->is_active ? 'Active' : 'Inactive' }}
                                </button>
                            </form>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.testimonials.edit', $testimonial) }}" class="btn btn-primary" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.testimonials.destroy', $testimonial) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Delete this testimonial?');">
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
                        <td colspan="8" class="text-center py-4">
                            <p class="text-muted mb-0">No testimonials found.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
