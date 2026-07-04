@extends('layouts.admin')

@section('title', 'Review Moderation')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0">Review Moderation</h2>
    <form method="GET" action="{{ route('admin.reviews.index') }}" class="d-flex align-items-center gap-2">
        <select name="rating" class="form-select form-select-sm" style="width:auto" onchange="this.form.submit()">
            <option value="">All Ratings</option>
            @for($i = 5; $i >= 1; $i--)
                <option value="{{ $i }}" {{ request('rating') == $i ? 'selected' : '' }}>{{ $i }} Star{{ $i > 1 ? 's' : '' }}</option>
            @endfor
        </select>
        <select name="status" class="form-select form-select-sm" style="width:auto" onchange="this.form.submit()">
            <option value="">All Status</option>
            <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
        </select>
        @if(request('rating') || request('status'))
            <a href="{{ route('admin.reviews.index') }}" class="btn btn-sm btn-outline-secondary">Clear</a>
        @endif
    </form>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Rating</th>
                        <th>Comment</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th style="width: 150px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reviews as $review)
                    <tr>
                        <td><strong>{{ $review->product->name }}</strong></td>
                        <td>{{ $review->name }}</td>
                        <td>{{ $review->email }}</td>
                        <td>
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star {{ $i <= $review->rating ? 'text-warning' : 'text-muted' }}"></i>
                            @endfor
                        </td>
                        <td>{{ Str::limit($review->comment, 50) }}</td>
                        <td>{{ $review->created_at->format('M d, Y') }}</td>
                        <td>
                            <span class="badge bg-{{ $review->is_approved ? 'success' : 'warning' }}">
                                {{ $review->is_approved ? 'Approved' : 'Pending' }}
                            </span>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                @if(!$review->is_approved)
                                <form action="{{ route('admin.reviews.approve', $review) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-success" title="Approve">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </form>
                                @endif
                                <form action="{{ route('admin.reviews.destroy', $review) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Delete this review?');">
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
                            <p class="text-muted mb-0">No reviews found.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    @if($reviews->hasPages())
    <div class="card-footer">
        {{ $reviews->links() }}
    </div>
    @endif
</div>
@endsection
